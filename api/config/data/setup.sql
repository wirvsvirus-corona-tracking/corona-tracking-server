CREATE DATABASE corona_tracker;

USE corona_tracker;

CREATE TABLE IF NOT EXISTS state
(
    id   INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID of the state.',
    name VARCHAR(30) NOT NULL COMMENT 'Name of the state.',

    PRIMARY KEY (id),
    UNIQUE KEY unique_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='All the possible states.';

CREATE TABLE IF NOT EXISTS profile
(
    id         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID of the profile.',
    guid       VARCHAR(32) NOT NULL COMMENT 'GUID of the profile.',
    passphrase VARCHAR(24) NOT NULL COMMENT 'Passphrase of the profile.',
    state_id   INT(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Current state of the profile.',

    PRIMARY KEY (id),
    FOREIGN KEY (state_id) REFERENCES state (id) ON DELETE CASCADE,
    UNIQUE KEY unique_guid (guid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='All the profiles with their current states.';

CREATE TABLE IF NOT EXISTS contact
(
    id           INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID of the contact.',
    timestamp    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of the contact.',
    profile_id_a INT(11) UNSIGNED NOT NULL COMMENT 'Profile As profile ID of the contact.',
    profile_id_b INT(11) UNSIGNED NOT NULL COMMENT 'Profile Bs profile ID of the contact.',

    PRIMARY KEY (id),
    FOREIGN KEY (profile_id_a) REFERENCES profile (id) ON DELETE CASCADE,
    FOREIGN KEY (profile_id_b) REFERENCES profile (id) ON DELETE CASCADE,
    UNIQUE KEY unique_contact (profile_id_a, profile_id_b)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='All the contacts between two profiles.';

INSERT INTO state (name) VALUES ('not infected'), ('infected');
