import React from "react";
import { Routes, Route } from "react-router-dom";
import Login from "./components/Login";
import UserCrud from "./components/UserCrud";
import Dashboard from "./components/Dashboard";
import PrivateRoute from "./components/PrivateRoute";

const App = () => {
  return (
    <Routes>
      <Route path="/" element={<Login />} />
      <Route path="/dashboard" element={<PrivateRoute><Dashboard /></PrivateRoute>} />
      <Route path="/users" element={<PrivateRoute><UserCrud /></PrivateRoute>} /> {/* Ruta para el CRUD */}
    </Routes>
  );
};

export default App;
