import re
import requests
import xml.etree.ElementTree as elementTree
from datetime import datetime
from waitress import serve
from flask import Flask, request, jsonify

app = Flask(__name__)

class TimetableSlot:
    def __init__(self, day, start_time, end_time, category, module, room, staff, section):
        self.day = day
        self.start_time = start_time
        self.end_time = end_time
        self.category = category
        self.module = module
        self.room = room
        self.staff = staff
        self.section = section

    def to_dict(self):
        return {
            'class_name': self.module,
            'class_category': self.category,
            'class_section': self.section,
            'class_lecturer': self.staff,
            'class_location': self.room,
            'class_day': self.day,
            'class_start_time': self.start_time,
            'class_end_time': self.end_time
        }

# Clean the data before appending to array
def clean_data(timetable_slot):
    # 1. Clean the module: Remove anything in brackets
    module_cleaned = re.sub(r'\(.*?\)', '', timetable_slot.module).strip()

    # 2. Clean the category based on predefined values
    category_map = {
        'KULIAH': 'lecture',
        'PERUBAHAN JADUAL KULIAH': 'lecture',
        'JADUAL KULIAH TAMBAHAN': 'lecture',
        'TUTORIAL': 'tutorial',
        'PERUBAHAN TUTORIAL': 'tutorial',
        'MAKMAL / AMALI': 'labprac',
        'KOKUM': 'cocurricular',
        'KOKUM (PKPP)': 'cocurricular'
    }
    category_cleaned = category_map.get(timetable_slot.category.upper(), timetable_slot.category.lower())

    # 3. Clean the section: Extract only the integer value
    section_cleaned = re.search(r'\d+', timetable_slot.section)
    section_cleaned = section_cleaned.group() if section_cleaned else timetable_slot.section

    # 4. Clean the start time and end time
    start_time_cleaned = datetime.strptime(timetable_slot.start_time, "%H:%M").strftime("%H:00:00")
    end_time_cleaned = datetime.strptime(timetable_slot.end_time, "%H:%M").strftime("%H:00:00")

    # Assign cleaned values back to the timetable slot
    timetable_slot.module = module_cleaned
    timetable_slot.category = category_cleaned
    timetable_slot.section = int(section_cleaned)
    timetable_slot.start_time = start_time_cleaned
    timetable_slot.end_time = end_time_cleaned

    return timetable_slot

@app.route('/subject-details-fetcher', methods=['POST'])
def fetch_subject_details():
    # Define the main URL and the target file path for saving the JSON (passed into here from the Laravel side)
    source_link = request.json['source_link']
    print(f"REQUEST: {source_link}")
    url = source_link.replace('.html', '.xml')

    try:
        response = requests.get(url, timeout=15)

        # Check for successful fetch
        print("INIT: Fetch successful")

        # Parse the XML
        root = elementTree.fromstring(response.content)

        timetable_slots = []
        count = 0

        # Parse events and add each as a new TimetableSlot object to the array
        for event in root.findall('.//event'):
            day = (1 + int(event.find('day').text)) if event.find(
                'day') is not None else -1  # (TEMPORARY!) day value + 1 as database takes values starting from 1 (Mon) to 7 (Sun)
            start_time = event.find('starttime').text if event.find('starttime') is not None else 'N/A'
            end_time = event.find('endtime').text if event.find('endtime') is not None else 'N/A'
            category = event.find('category').text if event.find('category') is not None else 'N/A'

            resources = event.find('resources')
            module = (
                resources.find('module').find('item').text
                if resources is not None and resources.find('module') is not None
                else 'N/A'
            )
            room = (
                resources.find('room').find('item').text
                if resources is not None and resources.find('room') is not None
                else 'N/A'
            )
            staff = (
                resources.find('staff').find('item').text
                if resources is not None and resources.find('staff') is not None 
                else 'N/A'
            )
            section = (
                resources.find('group').find('item').text 
                if resources is not None and resources.find('group') is not None
                else '1'
            )

            # Create a new TimetableSlot object
            slot = TimetableSlot(day, start_time, end_time, category, module, room, staff, section)

            # Clean the data before appending
            cleaned_slot = clean_data(slot)

            # Append to the array
            timetable_slots.append(cleaned_slot)

            # Increase the count
            count = count + 1

        print(f"Found a total of {count} timetable slots. Converting to list of dictionaries...")

        # Convert timetable slots to a list of dictionaries
        timetable_slots_dict = [slot.to_dict() for slot in timetable_slots]

        print(f"({datetime.now().strftime('%Y-%m-%d %H:%M:%S')}) (PASS) JSON created successfully")

        # Return the JSON
        return jsonify(timetable_slots_dict)
    except requests.exceptions.Timeout:
        print(f"({datetime.now().strftime('%Y-%m-%d %H:%M:%S')}) (FAIL) The request timed out")


if __name__ == '__main__':
    serve(app, host='0.0.0.0', port=5002)
    