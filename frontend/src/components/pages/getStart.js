import React, { useState } from "react";
import "./getStart.css";

export default function GetStart() {
  const [inputs, setInputs] = useState({
    pregnancies: "",
    glucose: "",
    bloodPressure: "",
    skinThickness: "",
    insulin: "",
    bmi: "",
    diabetesPedigreeFunction: "",
    age: "",
  });
  const [predictionResult, setPredictionResult] = useState("");

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setInputs((prevInputs) => ({
      ...prevInputs,
      [name]: value,
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    fetch("http://localhost:5000/api/predict", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(inputs),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then((prediction_result) => {
        if (prediction_result < 1) {
          setPredictionResult("The patient is likely not to have diabetes.");
        } else {
          setPredictionResult("The patient is likely to have diabetes.");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  return (
    <div className="hero-container">
      <video src="/videos/video-1.mp4" autoPlay loop muted />

      <div className="App">
        <div className="get-start-container-form">
          <h1 className="get-start-heading">Diabetes Predictor</h1>

          <form onSubmit={handleSubmit}>
            <div className="input-container">
              <label htmlFor="pregnancies">
                <div className="input-container-result">
                  Number of Pregnancies:
                </div>
              </label>

              <input
                id="pregnancies"
                type="text"
                name="pregnancies"
                value={inputs.pregnancies}
                onChange={handleInputChange}
              />
            </div>

            <div className="input-container">
              <label htmlFor="glucose">
                <div className="input-container-result">Glucose Level:</div>
              </label>
              <input
                id="glucose"
                type="text"
                name="glucose"
                value={inputs.glucose}
                onChange={handleInputChange}
              />
            </div>

            <div className="input-container">
              <label htmlFor="bloodPressure">
                <div className="input-container-result">Blood Pressure:</div>
              </label>
              <input
                id="bloodPressure"
                type="text"
                name="bloodPressure"
                value={inputs.bloodPressure}
                onChange={handleInputChange}
              />
            </div>

            <div className="input-container">
              <label htmlFor="skinThickness">
                <div className="input-container-result">Skin Thickness:</div>
              </label>
              <input
                id="skinThickness"
                type="text"
                name="skinThickness"
                value={inputs.skinThickness}
                onChange={handleInputChange}
              />
            </div>

            <div className="input-container">
              <label htmlFor="insulin">
                <div className="input-container-result">Insulin Level:</div>
              </label>
              <input
                id="insulin"
                type="text"
                name="insulin"
                value={inputs.insulin}
                onChange={handleInputChange}
              />
            </div>

            <div className="input-container">
              <label htmlFor="bmi">
                <div className="input-container-result">BMI:</div>
              </label>
              <input
                id="bmi"
                type="text"
                name="bmi"
                value={inputs.bmi}
                onChange={handleInputChange}
              />
            </div>

            <div className="input-container">
              <label htmlFor="diabetesPedigreeFunction">
                <div className="input-container-result">
                  Diabetes Pedigree Function:
                </div>
              </label>
              <input
                id="diabetesPedigreeFunction"
                type="text"
                name="diabetesPedigreeFunction"
                value={inputs.diabetesPedigreeFunction}
                onChange={handleInputChange}
              />
            </div>

            <div className="input-container">
              <label htmlFor="age">
                <div className="input-container-result">Age:</div>
              </label>
              <input
                id="age"
                type="text"
                name="age"
                value={inputs.age}
                onChange={handleInputChange}
              />
            </div>

            <center>
              <button type="submit" className="btn--medium">
                <b>SUBMIT</b>
              </button>
            </center>
          </form>
          <div className="input-container-result">
            {predictionResult && (
              <div className="prediction-result">
                <h2>Prediction Result:</h2>
                <p>{predictionResult}</p>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}
