from flask import Flask, jsonify, request
from flask_cors import CORS
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LogisticRegression
import os

app = Flask(__name__)
CORS(app)

# Use a relative path for the CSV file inside the container
file_path = './diabetes.csv'

# Load the CSV data
diabetes_data = pd.read_csv(file_path)

# Prepare the data for training
X = diabetes_data.drop(columns='Outcome', axis=1)
Y = diabetes_data['Outcome']

# Split the data
X_train, X_test, Y_train, Y_test = train_test_split(X, Y, test_size=0.2, stratify=Y, random_state=2)

# Initialize the Logistic Regression model
model = LogisticRegression(max_iter=1000)  # Increase the number of iterations
model.fit(X_train, Y_train)

# Route for predicting diabetes
@app.route('/api/predict', methods=['POST'])
def predict_diabetes():
    # Get the JSON request data
    req_data = request.json
    pregnancies = req_data['pregnancies']
    glucose = req_data['glucose']
    blood_pressure = req_data['bloodPressure']
    skin_thickness = req_data['skinThickness']
    insulin = req_data['insulin']
    bmi = req_data['bmi']
    diabetes_pedigree_function = req_data['diabetesPedigreeFunction']
    age = req_data['age']
    
    # Create a DataFrame from the input data
    user_data = pd.DataFrame({
        'Pregnancies': [pregnancies],
        'Glucose': [glucose],
        'BloodPressure': [blood_pressure],
        'SkinThickness': [skin_thickness],
        'Insulin': [insulin],
        'BMI': [bmi],
        'DiabetesPedigreeFunction': [diabetes_pedigree_function],
        'Age': [age]
    })
    
    # Predict the outcome using the trained model
    prediction_result = model.predict(user_data)

    # Return the prediction as a JSON response
    return jsonify(prediction_result.tolist())

# Main block to run the app
if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True)
