CREATE TABLE IF NOT EXISTS migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
);

INSERT INTO migrations (id, migration, batch) VALUES
(7, '0001_01_01_000000_create_users_table', 1),
(8, '0001_01_01_000001_create_cache_table', 1),
(9, '2025_01_14_094235_create_personal_access_tokens_table', 1);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at DATETIME NULL,
    passHash VARCHAR(255) NOT NULL,
    isAdmin TINYINT(1) NOT NULL DEFAULT 0,
    isBanned TINYINT(1) NOT NULL DEFAULT 0,
    remember_token VARCHAR(255) NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
);

CREATE TABLE IF NOT EXISTS password_reset_tokens (
    email VARCHAR(255) NOT NULL PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at DATETIME NULL
);

CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id INT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
);

CREATE TABLE IF NOT EXISTS cache (
    key VARCHAR(255) NOT NULL PRIMARY KEY,
    value TEXT NOT NULL,
    expiration INT NOT NULL
);

CREATE TABLE IF NOT EXISTS cache_locks (
    key VARCHAR(255) NOT NULL PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
);

CREATE TABLE IF NOT EXISTS personal_access_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    abilities TEXT NULL,
    last_used_at DATETIME NULL,
    expires_at DATETIME NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    INDEX personal_access_tokens_tokenable_type_tokenable_id_index (tokenable_type, tokenable_id)
);
