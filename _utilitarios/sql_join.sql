SELECT DISTINCT users_civil_status.*, users_esp.*
FROM users_civil_status
RIGHT  JOIN users_esp on users_civil_status.civil_status_id = users_esp.esp_id ;
