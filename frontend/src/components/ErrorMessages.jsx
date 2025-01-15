import React from "react";

const ErrorMessages = ({ errors }) => {
  return (
    <div className="alert alert-danger">
      <ul>
        {Object.keys(errors).map((key) => (
          <li key={key}>{errors[key]}</li>
        ))}
      </ul>
    </div>
  );
};

export default ErrorMessages;
