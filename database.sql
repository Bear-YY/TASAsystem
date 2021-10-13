-- テーブル作成
CREATE TABLE tb_user(
    usr_id  VARCHAR(16) ,   --  ユーザーID
    usr_name    VARCHAR(16) NOT NULL,   --  名前
    passwd  VARCHAR(16) NOT NULL,   --  パスワード
    usr_kind    INT ,   --  ユーザー種別
    usr_mail    VARCHAR(32) ,   --  メールアドレス
    PRIMARY KEY(usr_id)
);

CREATE TABLE tb_student(
    stu_id  CHAR(7) ,   --  学籍番号
    dpt_id  CHAR(2)  ,   --  学科ID
    usr_id  VARCHAR(16) ,   --  ユーザーID
    stu_name    VARCHAR(16) NOT NULL,   --  氏名
    stu_sex INT ,   --  性別
    stu_phoneno VARCHAR(16) ,   --  携帯番号
    stu_mail    VARCHAR(32) ,   --  メールアドレス
    ad_year INT ,   --  入学年度
    birthday    DATE    ,   --  生年月日
    stu_gpa FLOAT   ,   --  GPA
    stu_unit    INT  , --  習得単位数
    PRIMARY KEY(stu_id,dpt_id,usr_id)
);

CREATE TABLE tb_questionnaire(
    que_id  SERIAL  ,   --  アンケート番号
    que_title   TEXT    ,   --  アンケート名
    PRIMARY KEY(que_id)
);

CREATE TABLE tb_teacher(
    tea_id  VARCHAR(16) ,   --  教員ID
    usr_id  VARCHAR(16)  ,   --  ユーザーID
    dpt_id  CHAR(2) ,   --  学科ID
    tea_name    VARCHAR(16) NOT NULL,   --  氏名
    tea_mail    VARCHAR(32) ,   --  メールアドレス
    tea_phoneno VARCHAR(16) ,   --  電話番号
    tea_room    VARCHAR(16) ,   --  研究室番号
    tea_sex INT ,   --  性別
    PRIMARY KEY(tea_id,usr_id,dpt_id)
);

CREATE TABLE tb_department(
    dpt_id  CHAR(2) ,   --  学科ID
    fct_id  CHAR(1) ,   --  学部ID
    dpt_name    VARCHAR(16) NOT NULL,   --  学科名
    PRIMARY KEY(dpt_id,fct_id)
);

CREATE TABLE tb_faculty(
    fct_id  CHAR(1) ,   --  学部ID
    fct_name    VARCHAR(16) NOT NULL,   --  学部名
    PRIMARY KEY(fct_id)
);

CREATE TABLE tb_subject(
    sub_id  SERIAL  ,   --  科目ID
    dpt_id  CHAR(2) ,   --  学科ID
    category_id INT UNSIGNED ,   --  カテゴリーID
    sub_name    VARCHAR(16) NOT NULL,   --  科目名
    sub_unit    INT ,   --  単位数
    get_year    INT ,   --  取得学年
    sub_section INT ,   --  科目区分
    PRIMARY KEY(sub_id,dpt_id,category_id)
);

CREATE TABLE tb_timetable(
    tt_id   SERIAL  ,   --  時間割ID
    tea_id  VARCHAR(16) ,   --  教員ID
    sub_id  INT UNSIGNED,   --  科目ID
    semester    INT ,   --  学期
    tt_weekday  INT ,   --  曜日
    tt_timed    INT ,   --  時限
    tt_year INT ,   --  年度
    tt_classnum VARCHAR(16) ,   --  教室番号
    PRIMARY KEY(tt_id,tea_id,sub_id,role_id)
);

CREATE TABLE tb_schedule(
    sch_id  SERIAL  ,   --  スケジュール番号
    stu_id  CHAR(7) ,   --  学籍番号
    sch_name  VARCHAR(16) NOT NULL,   --  スケジュール名
    sch_weekday INT ,   --  曜日
    sch_timed   INT ,   --  時限
    sch_detail  TEXT    ,   --  スケジュール詳細
    scb_semester INT,  --学期
    PRIMARY KEY(sch_id,stu_id)
);

CREATE TABLE tb_role(
    role_id SERIAL  ,   --  役割ID
    role_kind    VARCHAR(2)  ,   --  役割名
    role_condition   TEXT    ,   --  役割条件
    PRIMARY KEY(role_id)
);

CREATE TABLE tb_category(
    category_id SERIAL  ,   --  カテゴリーID
    category_name   VARCHAR(16) ,   --  カテゴリー名
    PRIMARY KEY(category_id)
);

CREATE TABLE tb_recruitment(
    rec_id  SERIAL  ,   --  募集番号
    tt_id   INT UNSIGNED,   --  時間割ID
    role_id INT UNSIGNED,   --  役割ID
    tea_id  VARCHAR(16) ,   --  教員ID
    rec_day DATE    ,   --  募集日時
    rec_comment TEXT    ,   --  教員コメント
    rec_num INT ,   --  募集人数
    PRIMARY KEY(rec_id,tt_id,role_id,tea_id)
);

CREATE TABLE tb_application(
    app_id  SERIAL  ,   --  応募番号
    stu_id  CHAR(7) ,   --  学籍番号
    rec_id  INT UNSIGNED,   --  募集番号
    app_day DATE    ,   --  応募日時
    app_comment TEXT    ,   --  応募コメント
    app_result  INT ,   --  応募結果
    PRIMARY KEY(app_id,stu_id,rec_id)
);

CREATE TABLE tb_recommend(
    rcm_id  SERIAL  ,   --  推薦番号
    tea_id  VARCHAR(16) ,   --  教員ID
    stu_id  CHAR(7) ,   --  学籍番号
    rec_id  INT UNSIGNED,   --  募集番号
    rcm_day DATE    ,   --  推薦日時
    rcm_result  INT ,   --  推薦結果
    rcm_deadline    TIMESTAMP   ,   --  締切日時
    rcm_comment TEXT    ,   --  推薦文
    rcm_acomment    TEXT    ,   --  推薦回答文
    PRIMARY KEY(rec_id,tea_id,stu_id,rcm_id)
);

CREATE TABLE tb_answer(
    ans_id  SERIAL  ,   --  回答ID
    stu_id  CHAR(7) ,   --  学籍番号
    que_id  INT UNSIGNED,   --  アンケート番号
    ans_day DATE    ,   --  回答日時
    ans_value   INT ,   --  回答数値
    PRIMARY KEY(ans_id,stu_id,que_id)
);

CREATE TABLE tb_course(
    cou_id  SERIAL ,   --  履修番号
    stu_id  CHAR(7) ,   --  学籍番号
    sub_id  INT UNSIGNED,   --  科目ID
    grade   INT ,   --  成績
    cou_year    INT ,   --  年度
    PRIMARY KEY(cou_id,stu_id,sub_id)
);

CREATE TABLE tb_config(
    tt_id INT UNSIGNED, 
    que_id  INT UNSIGNED,   --  アンケート番号
    con_id  SERIAL  ,   --  設定ID
    con_value   INT ,   --  設定数値
    PRIMARY KEY(con_id,tt_id,que_id)
);

-- テーブルに外部キー(FOREIGN KEY)を追加
ALTER TABLE tb_student ADD 
FOREIGN KEY(dpt_id) REFERENCES tb_department(dpt_id);
ALTER TABLE tb_student ADD 
FOREIGN KEY(usr_id) REFERENCES tb_user(usr_id);

ALTER TABLE tb_teacher ADD
FOREIGN KEY(usr_id) REFERENCES tb_user(usr_id);
ALTER TABLE tb_teacher ADD
FOREIGN KEY(dpt_id) REFERENCES tb_department(dpt_id);
    
ALTER TABLE tb_department ADD
FOREIGN KEY(fct_id) REFERENCES tb_faculty(fct_id);

ALTER TABLE tb_subject ADD
FOREIGN KEY(dpt_id) REFERENCES tb_department(dpt_id);
ALTER TABLE tb_subject ADD
FOREIGN KEY(category_id) REFERENCES tb_category(category_id);

ALTER TABLE tb_timetable ADD 
FOREIGN KEY(tea_id) REFERENCES tb_teacher(tea_id);
ALTER TABLE tb_timetable ADD 
FOREIGN KEY(sub_id) REFERENCES tb_subject(sub_id);

ALTER TABLE tb_schedule ADD 
FOREIGN KEY(stu_id) REFERENCES tb_student(stu_id);

ALTER TABLE tb_recruitment ADD
FOREIGN KEY(tt_id) REFERENCES tb_timetable(tt_id);
ALTER TABLE tb_recruitment ADD
FOREIGN KEY(role_id) REFERENCES tb_role(role_id);
ALTER TABLE tb_recruitment ADD
FOREIGN KEY(tea_id) REFERENCES tb_teacher(tea_id);

ALTER TABLE tb_application ADD
FOREIGN KEY(stu_id) REFERENCES tb_student(stu_id);
ALTER TABLE tb_application ADD
FOREIGN KEY(rec_id) REFERENCES tb_recruitment(rec_id);

ALTER TABLE tb_recommend ADD
FOREIGN KEY(tea_id) REFERENCES tb_teacher(tea_id);
ALTER TABLE tb_recommend ADD
FOREIGN KEY(stu_id) REFERENCES tb_student(stu_id);
ALTER TABLE tb_recommend ADD
FOREIGN KEY(rec_id) REFERENCES tb_recruitment(rec_id);

ALTER TABLE tb_answer ADD
FOREIGN KEY(stu_id) REFERENCES tb_student(stu_id);
ALTER TABLE tb_answer ADD
FOREIGN KEY(que_id) REFERENCES tb_questionnaire(que_id);

ALTER TABLE tb_course ADD
FOREIGN KEY(stu_id) REFERENCES tb_student(stu_id);
ALTER TABLE tb_course ADD
FOREIGN KEY(sub_id) REFERENCES tb_subject(sub_id);

ALTER TABLE tb_config ADD
FOREIGN KEY(tt_id) REFERENCES tb_timetable(tt_id);
ALTER TABLE tb_config ADD
FOREIGN KEY(que_id) REFERENCES tb_questionnaire(que_id);


-- 仮データの登録 -------------------------------------------------------

-- tb_facultyにデータ追加
INSERT INTO tb_faculty(fct_id,fct_name) VALUES('R','理工学部');

-- tb_departmentにデータ追加
INSERT INTO tb_department(dpt_id,fct_id,dpt_name) VALUES('RS','R','情報科学科');

-- tb_userにデータ追加
INSERT INTO tb_user(usr_id,usr_name,passwd,usr_kind,usr_mail) 
VALUES('k30rs001','田中 亮','30001','1','k30rs001@st.kyusan.ac.jp'),
('k30rs002','伊藤 英樹','30002','1','k30rs002@st.kyusan.ac.jp'),
('k30rs003','山田 剛','30003','1','k30rs003@st.kyusan.ac.jp'),
('k30rs004','渡邉 和彦','30004','1','k30rs004@st.kyusan.ac.jp'),
('k30rs005','吉田 宏之','30005','1','k30rs005@st.kyusan.ac.jp'),
('k30rs006','田中 一男','30006','1','k30rs006@st.kyusan.ac.jp'),
('k30rs007','木村 友里','30007','1','k30rs007@st.kyusan.ac.jp'),
('k30rs008','山内 洋子','30008','1','k30rs008@st.kyusan.ac.jp'),
('k30rs009','藤田 絵里','30009','1','k30rs009@st.kyusan.ac.jp'),
('k30rs010','松下 直美','30010','1','k30rs010@st.kyusan.ac.jp'),
('kato','加藤 亮輔','1234','2','kato@is.kyusan.ac.jp'),
('matumoto','松本 敏之','2345','2','matumoto@is.kyusan.ac.jp'),
('konishi','小西 英樹','3456','2','konishi@is.kyusan.ac.jp'),
('yamagishi','山岸 茂','4567','2','yamagishi@is.kyusan.ac.jp'),
('thuchiya','土屋 愛子','5678','2','thuchiya@is.kyusan.ac.jp'),
('higuchi','樋口 憲一','9876','9','admin@ad.kyusan.ac.jp');


-- tb_studentにデータ追加
INSERT INTO tb_student(stu_id,dpt_id,usr_id,stu_name,stu_sex,ad_year,stu_phoneno) 
VALUES('30RS001','RS','k30rs001','田中 亮','1','2030','090-5918-5777'),
('30RS002','RS','k30rs002','伊藤 英樹','1','2030','090-1935-5508'),
('30RS003','RS','k30rs003','山田 剛','1','2030','090-2300-9542'),
('30RS004','RS','k30rs004','渡邉 和彦','1','2030','090-1935-5508'),
('30RS005','RS','k30rs005','吉田 宏之','1','2030','090-8055-6286'),
('30RS006','RS','k30rs006','田中 一男','1','2030','090-5918-5779'),
('30RS007','RS','k30rs007','木村 友里','2','2030','090-0441-9923'),
('30RS008','RS','k30rs008','山内 洋子','2','2030','090-2625-6453'),
('30RS009','RS','k30rs009','藤田 絵里','2','2030','090-8055-6286'),
('30RS010','RS','k30rs010','松下 直美','2','2030','090-0808-0949');

-- tb_teacherにデータ追加
INSERT INTO tb_teacher(tea_id,usr_id,dpt_id,tea_name,tea_sex,tea_phoneno) 
VALUES('kato','kato','RS','加藤　亮輔','1','090-6929-6453'),
('matumoto','matumoto','RS','松本 敏之','1','090-7069-6114'),
('konishi','konishi','RS','小西 英樹','1','090-3465-8946'),
('yamagishi','yamagishi','RS','山岸 茂','1','090-9713-6390'),
('thuchiya','thuchiya','RS','土屋 愛子','2','090-4390-2387'),
('higuchi','higuchi','RS','樋口 憲一','1','090-9635-50730-9635-5073');

-- tb_roleにデータ追加
INSERT INTO tb_role(role_id,role_kind,role_condition) VALUES('1','SA','学部生,成績A以上');
INSERT INTO tb_role(role_id,role_kind,role_condition) VALUES('2','TA','院生,成績A以上');

-- tb_categoryにデータ追加
INSERT INTO tb_category(category_id,category_name) 
VALUES('1','ソフトウェア'),
('2','ハードウェア'),
('3','数学'),
('4','インターネット・WEB'),
('5','情報処理');

-- tb_subjectにデータ追加
INSERT INTO tb_subject(sub_id,dpt_id,category_id,sub_name,sub_unit,get_year,sub_section) 
VALUES('1','RS','1','プログラミング基礎Ⅰ','2','2030','1'),
('2','RS','1','プログラミング基礎Ⅱ','2','2031','1'),
('3','RS','1','データ構造とアルゴリズムⅠ','2','2030','1'),
('4','RS','1','ゲームプログラミング演習','2','2030','2'),
('5','RS','2','組込みソフトウェア','2','2031','2'),
('6','RS','2','ハードウェア設計Ⅰ','2','2030','1'),
('7','RS','2','計算機構成論Ⅰ','2','2030','1'),
('8','RS','2','ハードウェア設計Ⅱ','2','2031','1'),
('9','RS','3','統計学','2','2030','2'),
('10','RS','3','離散数学Ⅰ','2','2030','1'),
('11','RS','3','離散数学Ⅱ','2','2031','2'),
('12','RS','3','線形代数Ⅰ','2','2030','1'),
('13','RS','4','データベース','2','2031','2'),
('14','RS','4','WEBプログラミング演習','2','2031','2'),
('15','RS','4','クラウドプログラミング演習','2','2030','2'),
('16','RS','4','コンピュータネットワーク','2','2030','1'),
('17','RS','5','情報リテラシー','2','2030','1'),
('18','RS','5','プロジェクトデザイン管理','2','2032','2'),
('19','RS','5','情報処理技術Ⅰ','2','2030','2'),
('20','RS','5','技術者倫理','2','2030','2');

-- tb_courseにデータを追加
INSERT INTO tb_course(cou_id,stu_id,sub_id,grade,cou_year)
VALUES('1','30RS001','1','2','2030'),
('2','30RS001','2','2','2031'),
('3','30RS001','3','2','2030'),
('4','30RS001','6','4','2030'),
('5','30RS001','7','3','2030'),
('6','30RS001','8','1','2031'),
('7','30RS001','10','3','2030'),
('8','30RS001','12','4','2030'),
('9','30RS001','16','2','2030'),
('10','30RS001','17','3','2030'),
('11','30RS001','4','4','2030'),
('12','30RS001','18','4','2032'),
('13','30RS001','11','2','2031'),
('14','30RS001','9','4','2030'),
('15','30RS001','13','3','2031'),
('16','30RS002','1','2','2030'),
('17','30RS002','2','2','2031'),
('18','30RS002','3','3','2030'),
('19','30RS002','6','2','2030'),
('20','30RS002','7','1','2030'),
('21','30RS002','8','1','2031'),
('22','30RS002','10','4','2030'),
('23','30RS002','12','3','2030'),
('24','30RS002','16','2','2030'),
('25','30RS002','17','2','2030'),
('26','30RS002','11','4','2031'),
('27','30RS002','4','3','2030'),
('28','30RS002','9','3','2030'),
('29','30RS002','14','1','2031'),
('30','30RS002','5','3','2031'),
('31','30RS003','1','3','2030'),
('32','30RS003','2','3','2031'),
('33','30RS003','3','4','2030'),
('34','30RS003','6','2','2030'),
('35','30RS003','7','3','2030'),
('36','30RS003','8','1','2031'),
('37','30RS003','10','2','2030'),
('38','30RS003','12','1','2030'),
('39','30RS003','16','2','2030'),
('40','30RS003','17','2','2030'),
('41','30RS003','20','3','2030'),
('42','30RS003','13','4','2031'),
('43','30RS003','9','4','2030'),
('44','30RS003','11','3','2031'),
('45','30RS003','5','3','2031'),
('46','30RS004','1','4','2030'),
('47','30RS004','2','3','2031'),
('48','30RS004','3','4','2030'),
('49','30RS004','6','2','2030'),
('50','30RS004','7','2','2030'),
('51','30RS004','8','3','2031'),
('52','30RS004','10','4','2030'),
('53','30RS004','12','3','2030'),
('54','30RS004','16','4','2030'),
('55','30RS004','17','3','2030'),
('56','30RS004','9','4','2030'),
('57','30RS004','19','4','2030'),
('58','30RS004','4','1','2030'),
('59','30RS004','11','3','2031'),
('60','30RS004','5','1','2031'),
('61','30RS005','1','1','2030'),
('62','30RS005','2','1','2031'),
('63','30RS005','3','4','2030'),
('64','30RS005','6','4','2030'),
('65','30RS005','7','3','2030'),
('66','30RS005','8','2','2031'),
('67','30RS005','10','1','2030'),
('68','30RS005','12','1','2030'),
('69','30RS005','16','1','2030'),
('70','30RS005','17','2','2030'),
('71','30RS005','5','3','2031'),
('72','30RS005','15','3','2030'),
('73','30RS005','18','2','2032'),
('74','30RS005','13','3','2031'),
('75','30RS005','9','1','2030'),
('76','30RS006','1','2','2030'),
('77','30RS006','2','4','2031'),
('78','30RS006','3','2','2030'),
('79','30RS006','6','1','2030'),
('80','30RS006','7','4','2030'),
('81','30RS006','8','1','2031'),
('82','30RS006','10','3','2030'),
('83','30RS006','12','2','2030'),
('84','30RS006','16','4','2030'),
('85','30RS006','17','2','2030'),
('86','30RS006','9','2','2030'),
('87','30RS006','14','2','2031'),
('88','30RS006','5','2','2031'),
('89','30RS006','15','1','2030'),
('90','30RS006','4','2','2030'),
('91','30RS007','1','4','2030'),
('92','30RS007','2','3','2031'),
('93','30RS007','3','4','2030'),
('94','30RS007','6','3','2030'),
('95','30RS007','7','2','2030'),
('96','30RS007','8','4','2031'),
('97','30RS007','10','4','2030'),
('98','30RS007','12','2','2030'),
('99','30RS007','16','2','2030'),
('100','30RS007','17','1','2030'),
('101','30RS007','20','1','2030'),
('102','30RS007','9','2','2030'),
('103','30RS007','5','3','2031'),
('104','30RS007','13','1','2031'),
('105','30RS007','11','2','2031'),
('106','30RS008','1','1','2030'),
('107','30RS008','2','4','2031'),
('108','30RS008','3','3','2030'),
('109','30RS008','6','3','2030'),
('110','30RS008','7','2','2030'),
('111','30RS008','8','1','2031'),
('112','30RS008','10','3','2030'),
('113','30RS008','12','4','2030'),
('114','30RS008','16','3','2030'),
('115','30RS008','17','4','2030'),
('116','30RS008','20','2','2030'),
('117','30RS008','9','2','2030'),
('118','30RS008','5','2','2031'),
('119','30RS008','13','2','2031'),
('120','30RS008','11','2','2031'),
('121','30RS009','1','2','2030'),
('122','30RS009','2','4','2031'),
('123','30RS009','3','3','2030'),
('124','30RS009','6','4','2030'),
('125','30RS009','7','3','2030'),
('126','30RS009','8','4','2031'),
('127','30RS009','10','4','2030'),
('128','30RS009','12','2','2030'),
('129','30RS009','16','4','2030'),
('130','30RS009','17','2','2030'),
('131','30RS009','9','4','2030'),
('132','30RS009','4','3','2030'),
('133','30RS009','13','4','2031'),
('134','30RS009','5','2','2031'),
('135','30RS009','11','2','2031'),
('136','30RS010','1','2','2030'),
('137','30RS010','2','4','2031'),
('138','30RS010','3','1','2030'),
('139','30RS010','6','1','2030'),
('140','30RS010','7','4','2030'),
('141','30RS010','8','1','2031'),
('142','30RS010','10','3','2030'),
('143','30RS010','12','4','2030'),
('144','30RS010','16','3','2030'),
('145','30RS010','17','2','2030'),
('146','30RS010','20','1','2030'),
('147','30RS010','18','4','2032'),
('148','30RS010','13','4','2031'),
('149','30RS010','9','1','2030'),
('150','30RS010','5','3','2031');


INSERT INTO tb_timetable(tt_id,tea_id,sub_id,semester,tt_weekday,tt_timed,tt_year,tt_classnum) 
VALUES('1','kato','1','1','2','1','2030','12104'),
('2','kato','2','2','2','2','2031','12104'),
('3','kato','3','2','3','1','2030','12107'),
('4','kato','4','1','3','3','2030','12107'),
('5','matumoto','5','1','1','3','2031','12203'),
('6','matumoto','6','2','1','1','2030','12201'),
('7','matumoto','7','1','3','2','2030','12103'),
('8','matumoto','8','2','3','3','2031','12203'),
('9','konishi','9','1','4','4','2030','12106'),
('10','konishi','10','1','4','3','2030','12109'),
('11','konishi','11','2','5','4','2031','12107'),
('12','konishi','12','2','5','2','2030','12108'),
('13','yamagishi','13','2','2','1','2031','12109'),
('14','yamagishi','14','1','2','2','2031','12201'),
('15','yamagishi','15','2','5','3','2030','12104'),
('16','yamagishi','16','1','5','1','2030','12105'),
('17','thuchiya','17','3','4','2030','12103'),
('18','thuchiya','18','2','1','2032','12107'),
('19','thuchiya','19','4','3','2030','12208'),
('20','thuchiya','20','1','4','2030','12209');



INSERT INTO tb_course(stu_id,sub_id,grade,cou_year)
VALUES('1','30RS999','1','1','2030'),
('30RS999','2','1','2031'),
('30RS999','3','1','2030'),
('30RS999','4','1','2030'),
('30RS999','5','1','2031'),
('30RS999','6','1','2030'),
('30RS999','7','1','2030'),
('30RS999','8','1','2031'),
('30RS999','9','1','2030'),
('30RS999','10','1','2030'),
('30RS999','11','1','2031'),
('30RS999','12','1','2030'),
('30RS999','13','1','2031'),
('30RS999','14','1','2031'),
('30RS999','15','1','2030'),
('30RS999','16','1','2030'),
('30RS999','17','1','2030'),
('30RS999','18','1','2032'),
('30RS999','19','1','2030'),
('30RS999','20','1','2030'),

-- 優秀な生徒(全科目S)
INSERT INTO tb_user(usr_id,usr_name,passwd,usr_kind,usr_mail) 
VALUES('k30rs999','完璧 太郎','30999','1','k30rs999@st.kyusan.ac.jp')
INSERT INTO tb_student(stu_id,dpt_id,usr_id,stu_name,stu_sex,ad_year,stu_phoneno) 
VALUES('30RS999','RS','k30rs999','完璧 太郎','1','2030','090-5918-5778')
INSERT INTO tb_course(stu_id,sub_id,grade,cou_year)
VALUES('30RS999','1','1','2030'),
('30RS999','2','1','2031'),
('30RS999','3','1','2030'),
('30RS999','4','1','2030'),
('30RS999','5','1','2031'),
('30RS999','6','1','2030'),
('30RS999','7','1','2030'),
('30RS999','8','1','2031'),
('30RS999','9','1','2030'),
('30RS999','10','1','2030'),
('30RS999','11','1','2031'),
('30RS999','12','1','2030'),
('30RS999','13','1','2031'),
('30RS999','14','1','2031'),
('30RS999','15','1','2030'),
('30RS999','16','1','2030'),
('30RS999','17','1','2030'),
('30RS999','18','1','2032'),
('30RS999','19','1','2030'),
('30RS999','20','1','2030');

