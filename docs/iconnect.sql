SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS chat_rooms;
DROP TABLE IF EXISTS friends;
DROP TABLE IF EXISTS users;

SET FOREIGN_KEY_CHECKS = 1;

-- 1. Usersテーブル
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nickname VARCHAR(100),
  department VARCHAR(100),
  languages_spoken VARCHAR(255),
  hobbies VARCHAR(255),
  self_intro TEXT,
  picture VARCHAR(255),
  gender VARCHAR(50), -- TEXTよりVARCHAR推奨
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Friendsテーブル
CREATE TABLE friends (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    friend_id INT NOT NULL,
    status ENUM('accepted', 'pending', 'blocked') DEFAULT 'accepted',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY unique_friend_pair (user_id, friend_id),
    
    -- 外部キー制約
    CONSTRAINT fk_friends_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_friends_friend FOREIGN KEY (friend_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Chat Roomsテーブル
CREATE TABLE chat_rooms (
    id CHAR(36) PRIMARY KEY, -- UUIDを入れる想定
    user1_id INT NOT NULL,
    user2_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE KEY unique_pair (user1_id, user2_id),

    -- ここも外部キー制約をつけておくと安全です（ユーザーが消えたらチャットも消えるなど）
    CONSTRAINT fk_chatroom_user1 FOREIGN KEY (user1_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_chatroom_user2 FOREIGN KEY (user2_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;