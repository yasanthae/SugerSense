# from flask import Flask, jsonify, request
# from flask_cors import CORS
# import pandas as pd
# from sklearn.linear_model import LogisticRegression
# from sklearn.model_selection import train_test_split

# app = Flask(__name__)
# CORS(app)

# # Load the trained model
# file_path = 'D:/Campus/ICBT_COMPUTER/FINAL_PROJECT/Diabetes Prediction using machine learning-FINAL PROJECT/Project/diabetes.csv'
# diabetes_data = pd.read_csv(file_path)
# X = diabetes_data.drop(columns='Outcome', axis=1)
# Y = diabetes_data['Outcome']
# X_train, X_test, Y_train, Y_test = train_test_split(X, Y, test_size=0.2, stratify=Y, random_state=2)
# model = LogisticRegression()
# model.fit(X_train, Y_train)

# @app.route('/', methods=['POST'])
# def get_data():
#     req_data = request.get_json()
#     data = {
#         'Pregnancies': [req_data['Pregnancies']],
#         'Glucose': [req_data['Glucose']],
#         'BloodPressure': [req_data['BloodPressure']],
#         'SkinThickness': [req_data['SkinThickness']],
#         'Insulin': [req_data['Insulin']],
#         'BMI': [req_data['BMI']],
#         'DiabetesPedigreeFunction': [req_data['DiabetesPedigreeFunction']],
#         'Age': [req_data['Age']]
#     }
#     # Make predictions
#     prediction_result = model.predict(pd.DataFrame(data))
    
#     # Convert prediction result to list for jsonify
#     #prediction_list = prediction_result.tolist()
    
#     # Return prediction result
#     return jsonify({'prediction': prediction_result.tolist()})

# if __name__ == '__main__':
#     app.run(host='0.0.0.0', port=5000, debug=True)

from flask import Flask, jsonify, request
from flask_cors import CORS
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LogisticRegression

app = Flask(__name__)
CORS(app)

file_path = 'D:/Campus/ICBT_COMPUTER/FINAL_PROJECT/Diabetes Prediction using machine learning-FINAL PROJECT/Project/diabetes.csv'
diabetes_data = pd.read_csv(file_path)
X = diabetes_data.drop(columns='Outcome', axis=1)
Y = diabetes_data['Outcome']
X_train, X_test, Y_train, Y_test = train_test_split(X, Y, test_size=0.2, stratify=Y, random_state=2)
model = LogisticRegression(max_iter=1000)  # Increase the number of iterations
model.fit(X_train, Y_train)

@app.route('/api/predict', methods=['POST'])
def predict_diabetes():
    req_data = request.json
    pregnancies = req_data['pregnancies']
    glucose = req_data['glucose']
    blood_pressure = req_data['bloodPressure']
    skin_thickness = req_data['skinThickness']
    insulin = req_data['insulin']
    bmi = req_data['bmi']
    diabetes_pedigree_function = req_data['diabetesPedigreeFunction']
    age = req_data['age']
    
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
    
    prediction_result = model.predict(user_data)
    
    # Convert int64 prediction_result to Python integer
    prediction_result = int(prediction_result[0])
    
# @app.route('/api/data', methods=['GET'])
# def get_data():
#     data={

#         "prediction_result":"hiii"
#     }
    return jsonify(prediction_result)

   

if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True)
