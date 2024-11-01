document.addEventListener('DOMContentLoaded', function() {
    let facultyCourses = [];

    // Fetch the JSON file
    fetch('/resources/data/faculties_and_courses.json')
        .then(response => response.json())
        .then(data => {
            facultyCourses = data;
            // Pre-select the faculty and populate courses if they already exist
            let selectedFaculty = document.querySelector('meta[name="profile-faculty"]').getAttribute('content');
            let selectedCourse = document.querySelector('meta[name="profile-course"]').getAttribute('content');
            
            const courseDropdown = document.getElementById('course');
            if (!selectedFaculty) {
                courseDropdown.innerHTML = '<option selected disabled value="">Select a faculty first</option>';
            }

            if (selectedFaculty) {
                const facultyDropdown = document.getElementById('faculty');
                facultyDropdown.value = selectedFaculty;
                populateCourses(selectedFaculty, selectedCourse);
            }
        })
        .catch(error => console.error('Error fetching JSON: ', error));

    // Handle change event for faculty dropdown
    document.getElementById('faculty').addEventListener('change', function() {
        const selectedFaculty = this.value;
        const courseDropdown = document.getElementById('course');

        courseDropdown.value = '';
        courseDropdown.innerHTML = '<option selected disabled value="">Choose...</option>';

        populateCourses(selectedFaculty);
    });

    function populateCourses(faculty, selectedCourse = null) {
        const courseDropdown = document.getElementById('course');
        courseDropdown.value = '';
        courseDropdown.innerHTML = '<option selected disabled value="">Choose...</option>';

        if (facultyCourses[faculty]) {
            facultyCourses[faculty].forEach(function(course) {
                const option = document.createElement('option');
                option.value = course.course_code;
                option.textContent = `${course.course_code} ${course.course_name}`;

                // Pre-select course if provided
                if (course.course_code === selectedCourse) {
                    option.selected = true;
                }

                courseDropdown.appendChild(option);
            });
        } else {
            courseDropdown.innerHTML = '<option selected disabled value="">Select a faculty first</option>';
        }
    }
});
