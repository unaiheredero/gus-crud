import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import "./styles.css"; // Asegúrate de que la ruta sea correcta

const Login = () => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState(""); // Valor por defecto de la contraseña
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false); // Estado para indicar la carga
  const navigate = useNavigate();

  const handleLogin = async (e) => {
    e.preventDefault();
    if (!email || !password) {
      setError("Email and password are required.");
      return;
    }

    setLoading(true); // Activar carga

    try {
      const response = await axios.post("http://127.0.0.1:8000/api/login", { email, password });
      const { token } = response.data;
      localStorage.setItem("token", token);
      navigate("/users");
    } catch (err) {
      setError("Invalid credentials. Please try again.");
    } finally {
      setLoading(false); // Desactivar carga
    }
  };

  return (
    <div className="container">
      <h2 className="title">Login</h2>
      {error && <p className="error">{error}</p>}
      <form onSubmit={handleLogin} className="form" autoComplete="off">
        <input
          type="email"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          className="input"
        />
        <input
          type="password"
          placeholder="Password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          className="input"
        />
        <button type="submit" className="button" disabled={loading}>
          {loading ? "Logging in..." : "Login"}
        </button>
      </form>

    </div>
  );
};

export default Login;
