ALTER TABLE dt_revenues
  ADD sl_daban int(11) DEFAULT 0 AFTER quantity,
  ADD sl_chuaban int(11) DEFAULT 0 AFTER sl_daban,
  ADD sl_tralai int(11) DEFAULT 0 AFTER sl_chuaban;


CREATE TABLE dt_clearing_debt (
  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  dt_revenue_id int(11) NOT NULL,
  clearing_vat bigint(11) DEFAULT 0,
  clearing_novat bigint(11) DEFAULT 0,
  sl_tralai bigint(11) DEFAULT 0,
  reason text,
  note text,
  created_user_id INT(11) NOT NULL,
  updated_user_id INT(11) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL
) ENGINE INNODB;

