-- users table作成
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    path VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL,
    PRIMARY KEY (id)
);
-- 


-- projects table作成
CREATE TABLE projects (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    name VARCHAR(20) NOT NULL,
    description TEXT NOT NULL,
    color_type VARCHAR(20) NOT NULL,
    created_at DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
-- 


-- tasks table作成
CREATE TABLE tasks (
    id INT(11) NOT NULL AUTO_INCREMENT,
    project_id INT(11) NOT NULL,
    title VARCHAR(20) NOT NULL,
    description TEXT NOT NULL,
    order_num INT(11) NOT NULL,
    status VARCHAR(20) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);
-- 