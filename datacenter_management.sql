-- ============================================
-- BASE DE DONNÉES : datacenter_management
-- Conforme au projet Laravel + énoncé
-- ============================================

CREATE DATABASE IF NOT EXISTS datacenter_management;
USE datacenter_management;

-- ============================================
-- Table : users
-- ============================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('guest', 'user', 'technician', 'admin') DEFAULT 'guest',
    departement VARCHAR(50) NULL,
    phone VARCHAR(20) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    remember_token VARCHAR(100) NULL,
    email_verified_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================
-- Table : categories
-- ============================================
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT NULL,
    icon VARCHAR(50) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Table : resources
-- ============================================
CREATE TABLE resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    category_id INT NULL,
    type ENUM('server', 'vm', 'storage', 'network', 'software', 'other') DEFAULT 'server',
    description TEXT NULL,
    specifications JSON NULL, -- Stocke CPU, RAM, OS, capacité, etc.
    status ENUM('available', 'in_use', 'maintenance', 'disabled') DEFAULT 'available',
    quantity INT DEFAULT 1,
    location VARCHAR(50) NULL,
    managed_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (managed_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- Table : reservations
-- ============================================
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    resource_id INT NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    purpose TEXT NOT NULL,
    justification TEXT NULL,
    status ENUM('pending', 'approved', 'rejected', 'active', 'finished') DEFAULT 'pending',
    approved_by INT NULL,
    rejected_reason TEXT NULL,
    admin_notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (resource_id) REFERENCES resources(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- Table : maintenance_schedules
-- ============================================
CREATE TABLE maintenance_schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    resource_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    reason ENUM('preventive', 'corrective', 'upgrade', 'other') DEFAULT 'preventive',
    status ENUM('scheduled', 'in_progress', 'completed', 'cancelled') DEFAULT 'scheduled',
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (resource_id) REFERENCES resources(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

-- ============================================
-- Table : issues
-- ============================================
CREATE TABLE issues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    type ENUM('technical', 'question', 'suggestion', 'incident') DEFAULT 'technical',
    status ENUM('open', 'in_progress', 'resolved', 'closed') DEFAULT 'open',
    priority ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
    assigned_to INT NULL,
    resource_id INT NULL,
    resolution TEXT NULL,
    resolved_at DATETIME NULL,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (resource_id) REFERENCES resources(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

-- ============================================
-- Table : notifications
-- ============================================
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('technical', 'question', 'suggestion', 'incident', 'reservation', 'maintenance', 'system') DEFAULT 'system',
    title VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    related_type ENUM('reservation', 'maintenance', 'issue', 'system') DEFAULT 'system',
    related_id INT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    read_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ============================================
-- Table : logs (journalisation)
-- ============================================
CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    action VARCHAR(100) NOT NULL,
    table_name VARCHAR(50) NULL,
    record_id INT NULL,
    details TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- INDEX pour performances
-- ============================================
CREATE INDEX idx_reservations_dates ON reservations(start_date, end_date);
CREATE INDEX idx_reservations_user ON reservations(user_id, status);
CREATE INDEX idx_reservations_resource ON reservations(resource_id, status);
CREATE INDEX idx_resources_status ON resources(status);
CREATE INDEX idx_resources_category ON resources(category_id);
CREATE INDEX idx_notifications_user ON notifications(user_id, is_read, created_at);
CREATE INDEX idx_issues_priority ON issues(priority, status);
CREATE INDEX idx_issues_assigned ON issues(assigned_to, status);
CREATE INDEX idx_maintenance_resource ON maintenance_schedules(resource_id, start_date);

-- ============================================
-- DONNÉES INITIALES
-- ============================================

-- Catégories
INSERT INTO categories (name, description, icon) VALUES
('Serveurs', 'Serveurs physiques et racks', 'server'),
('Machines Virtuelles', 'VM avec différentes configurations', 'vm'),
('Stockage', 'Baies de stockage, SAN, NAS', 'storage'),
('Réseau', 'Switch, routeur, firewall', 'network'),
('Logiciels', 'Licences et applications', 'software');

-- Admin par défaut (mot de passe : admin123)
INSERT INTO users (name, email, password, role, departement, is_active) VALUES
('Admin DataCenter', 'admin@datacenter.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'IT', 1);

-- Exemple de ressource
INSERT INTO resources (name, category_id, type, description, specifications, status, location, managed_by) VALUES
('Serveur HP DL380', 1, 'server', 'Serveur rackable 2U', '{"cpu": "2x Xeon", "ram": "64GB", "os": "Ubuntu 20.04", "storage": "1TB SSD"}', 'available', 'Rack A-01', 1);