from flask import Flask, request, jsonify, render_template
from flask_cors import CORS
import joblib
import numpy as np

app = Flask(__name__, template_folder='templates')
CORS(app, resources={r"/predict_loan_approval": {"origins": "http://localhost:3000"}})

# Load the pre-trained model during startup
model = joblib.load('./model.joblib')

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/predict_loan_approval', methods=['POST'])
def predict_loan_approval():
    data = request.get_json()

    # Extract input features from the JSON data
    input_features = np.array([
        data['Gender'],
        data['Married'],
        data['Dependents'],
        data['Education'],
        data['ApplicantIncome'],
        data['LoanAmount'],
        data['Loan_Amount_Term'],
        data['Credit_History']
    ]).reshape(1, -1)  # Reshape to a 2D array

    # Make a prediction
    prediction = model.predict(input_features)

    # Return the prediction as JSON
    return jsonify({'prediction': prediction[0]})


if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0')
