import React, { useEffect, useState } from 'react';
import axios from 'axios';

const UserCrud = () => {
  const [users, setUsers] = useState([]);
  const [newUser, setNewUser] = useState({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    is_admin: false,
    is_banned: false,
  });
  const [editUser, setEditUser] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetchUsers();
  }, []);

  const fetchUsers = async () => {
    setLoading(true);
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/users');
      setUsers(response.data);
    } catch (error) {
      console.error('Error fetching users', error);
    } finally {
      setLoading(false);
    }
  };

  const handleCreate = async () => {
    try {
      await axios.post('http://127.0.0.1:8000/api/users', newUser);
      fetchUsers();
      setNewUser({ name: '', email: '', password: '', password_confirmation: '', is_admin: false, is_banned: false });
      setError(null);
    } catch (error) {
      const errorMessage = error.response?.data?.message || 'Error creating user';
      setError(errorMessage);
    }
  };

  const handleUpdate = async () => {
    try {
      if (!editUser.password) {
        delete editUser.password;
      }
      await axios.put(`http://127.0.0.1:8000/api/users/${editUser.id}`, editUser);
      fetchUsers();
      setEditUser(null);
      setError(null);
    } catch (error) {
      const errorMessage = error.response?.data?.message || 'Error updating user';
      setError(errorMessage);
    }
  };

  const handleDelete = async (userId) => {
    try {
      await axios.delete(`http://127.0.0.1:8000/api/users/${userId}`);
      fetchUsers();
      setError(null);
    } catch (error) {
      const errorMessage = error.response?.data?.message || 'Error deleting user';
      setError(errorMessage);
    }
  };

  return (
    <div className="container">
      <h1 className="title">User Management</h1>
      {error && <div className="error">{error}</div>}

      <div className="form">
        <h2>Create User</h2>
        <form autoComplete="off"> {/* Desactiva autocompletado para este formulario */}
          <input
            type="text"
            className="input"
            placeholder="Name"
            value={newUser.name}
            onChange={(e) => setNewUser({ ...newUser, name: e.target.value })}
            autoComplete="new-name" // Para evitar conflictos de navegador
          />
          <input
            type="email"
            className="input"
            placeholder="Email"
            value={newUser.email}
            onChange={(e) => setNewUser({ ...newUser, email: e.target.value })}
            autoComplete="new-email"
          />
          <input
            type="password"
            className="input"
            placeholder="Password"
            value={newUser.password}
            onChange={(e) => setNewUser({ ...newUser, password: e.target.value })}
            autoComplete="new-password"
          />
          <input
            type="password"
            className="input"
            placeholder="Confirm Password"
            value={newUser.password_confirmation}
            onChange={(e) => setNewUser({ ...newUser, password_confirmation: e.target.value })}
            autoComplete="new-password"
          />
          <div>
            <input
              type="checkbox"
              checked={newUser.is_admin}
              onChange={() => setNewUser({ ...newUser, is_admin: !newUser.is_admin })}
            />
            Admin
            <input
              type="checkbox"
              checked={newUser.is_banned}
              onChange={() => setNewUser({ ...newUser, is_banned: !newUser.is_banned })}
            />
            Banned
          </div>
          <button className="button" onClick={handleCreate}>Create</button>
        </form>
      </div>

      <h2>User List</h2>
      {loading ? (
        <p>Loading...</p>
      ) : (
        <table className="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Admin</th>
              <th>Banned</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {users.map((user) => (
              <tr key={user.id}>
                <td>{user.name}</td>
                <td>{user.email}</td>
                <td>{user.is_admin ? 'Yes' : 'No'}</td>
                <td>{user.is_banned ? 'Yes' : 'No'}</td>
                <td>
                  <button className="button" onClick={() => setEditUser(user)}>Edit</button>
                  <button className="button" onClick={() => handleDelete(user.id)}>Delete</button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      )}

      {editUser && (
        <div className="form">
          <h2>Edit User</h2>
          <form autoComplete="off"> {/* Desactiva autocompletado */}
            <input
              type="text"
              className="input"
              value={editUser.name}
              onChange={(e) => setEditUser({ ...editUser, name: e.target.value })}
              autoComplete="off"
            />
            <input
              type="email"
              className="input"
              value={editUser.email}
              onChange={(e) => setEditUser({ ...editUser, email: e.target.value })}
              autoComplete="off"
            />
            <input
              type="password"
              className="input"
              value={editUser.password || ''}
              onChange={(e) => setEditUser({ ...editUser, password: e.target.value })}
              placeholder="Leave empty to keep current password"
              autoComplete="new-password"
            />
            <input
              type="password"
              className="input"
              value={editUser.password_confirmation || ''}
              onChange={(e) =>
                setEditUser({ ...editUser, password_confirmation: e.target.value })
              }
              placeholder="Confirm new password"
              autoComplete="new-password"
            />
            <div>
              <input
                type="checkbox"
                checked={editUser.is_admin}
                onChange={() => setEditUser({ ...editUser, is_admin: !editUser.is_admin })}
              />
              Admin
              <input
                type="checkbox"
                checked={editUser.is_banned}
                onChange={() => setEditUser({ ...editUser, is_banned: !editUser.is_banned })}
              />
              Banned
            </div>
            <button className="button" onClick={handleUpdate}>Update</button>
          </form>
        </div>
      )}
    </div>
  );
};

export default UserCrud;
