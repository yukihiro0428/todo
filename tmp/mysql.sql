CREATE TABLE todos (
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255) NOT NULL,
	detail TEXT DEFAULT NULL,
	status tinyint NOT NULL DEFAULT 0,
	completed_at DATETIME,
	created_at DATETIME NOT NULL,
	updated_at DATETIME NOT NULL,
	deleted_at DATETIME
) DEFAULT CHARACTER SET=utf8;


CREATE TABLE reviews (
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255),
	author VARCHAR(100),
	status VARCHAR(5),
	time DATE,
	evaluation INTEGER(1),
	impressions VARCHAR(1000),
	creation_date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET=utf8;





INSERT INTO
todos (title, detail, status, created_at, updated_at)
VALUES
('test', 'this is test', 0, now(), now());


CREATE TABLE todos (
	id int auto_increment NOT NULL,
	title varchar(255) NOT NULL DEFAULT 0 COMMENT 'タイトル',
	detail text DEFAULT NULL COMMENT '詳細',
	status tinyint NOT NULL DEFAULT 0 COMMENT 'ステータス(0: 未完了 1: 完了)',
	completed_at datetime COMMENT '完了日時',
	created_at datetime NOT NULL COMMENT '作成日時',
	updated_at datetime NOT NULL COMMENT '更新日時',
	deleted_at datetime COMMENT '削除日時',
	PRIMARY KEY (id)
) CHARSET=utf8 COMMENT='todo管理テーブル';
