from datetime import datetime
from flask import Flask, request, jsonify
from sklearn.neighbors import NearestNeighbors
from sklearn.preprocessing import StandardScaler
from waitress import serve
import numpy as np

app = Flask(__name__)

def flatten_traits(traits):
    """
    Flatten the traits dictionary into a single list of features (vector) for kNN input.
    This function assumes that traits like 'wtc_data', 'personality_data', and 'skills_data'
    are dictionaries or lists of numerical values.
    """
    return (
        list(traits['wtc_data'].values()) +
        list(traits['personality_data'].values()) +
        list(traits['skills_data'].values()) +
        [traits['learning_style']]  # Add learning style as a single value
    )


@app.route('/recommendation-engine', methods=['POST'])
def recommend_partners():
    own_record = request.json['user_traits_record']
    other_students_records = request.json['other_students_traits_records']

    # Flatten the current user's traits
    own_features = flatten_traits(own_record)

    # Create a list of profile IDs and a list of feature vectors for all other students
    student_ids = []
    student_features = []

    for student in other_students_records:
        student_ids.append(student['profile_id'])
        student_features.append(flatten_traits(student))

    # Convert to NumPy arrays
    student_features_np = np.array(student_features)
    own_features_np = np.array(own_features).reshape(1, -1)

    # Standardize features (z-score normalization)
    scaler = StandardScaler()
    student_features_np = scaler.fit_transform(student_features_np)
    own_features_np = scaler.transform(own_features_np)

    # Apply kNN with cosine similarity
    knn = NearestNeighbors(n_neighbors=10, metric='cosine')
    knn.fit(student_features_np)
    distances, indices = knn.kneighbors(own_features_np)

    # Convert cosine distances to similarities
    recommendations = [
        {
            'profile_id': student_ids[idx],
            'similarity': 1 - dist  # Convert distance to similarity
        }
        for dist, idx in zip(distances[0], indices[0])
    ]

    # Return the top 10 recommendations
    print(f"({datetime.now().strftime('%Y-%m-%d %H:%M:%S')}) Returning recommendations...")
    return jsonify(recommendations[:10])


if __name__ == '__main__':
    serve(app, host='0.0.0.0', port=5000)
    