// src/api.js
import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api'; // URL del backend de Laravel

// Función para hacer login
export const loginUser = async (email, password) => {
    try {
        const response = await axios.post(`${API_URL}/login`, { email, password });
        return response.data;
    } catch (error) {
        throw new Error('Error en el login: ' + error.message);
    }
};
