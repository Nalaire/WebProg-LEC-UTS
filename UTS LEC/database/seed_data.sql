USE event_registration_system;

-- Fake Data
INSERT INTO users (name, email, password, is_admin) VALUES 
('Admin User', 'admin@example.com', MD5('adminpassword'), TRUE),
('Regular User', 'user@example.com', MD5('userpassword'), FALSE);

-- Sample Events
INSERT INTO events (event_name, event_date, event_location, event_description, event_image, max_participants, event_status) VALUES 
('Tech Conference 2024', '2024-11-10', 'New York', 'A technology conference focusing on AI, robotics, and future tech.', 'tech_conference.png', 100, 'open'),
('Art Workshop', '2024-12-05', 'Los Angeles', 'An interactive workshop exploring different art techniques.', 'art_workshop.png', 50, 'open'),
('Music Festival', '2024-12-20', 'Chicago', 'A weekend-long festival with various musical performances.', 'music_festival.png', 500, 'open');

-- Sample Registration
INSERT INTO registrations (user_id, event_id) VALUES 
(2, 1),  -- Regular user registers for Tech Conference
(2, 2);  -- Regular user registers for Art Workshop
