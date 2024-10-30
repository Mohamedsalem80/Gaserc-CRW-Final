CREATE TABLE Countries (
    CountryID INT PRIMARY KEY,
    Country VARCHAR(100),
    Country_ar VARCHAR(100)
);

CREATE TABLE Subjects (
    SubjectID INT PRIMARY KEY,
    Subject VARCHAR(255),
    Subject_ar VARCHAR(255)
);

CREATE TABLE GradeLevels (
    GradeID INT PRIMARY KEY,
    Grade INT,
    Grade_ar VARCHAR(32)
);

CREATE TABLE CountriesData (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    CountryID INT,
    no_weeks INT NOT NULL,
    minutes INT NOT NULL,
    Grade_1 INT NOT NULL,
    Grade_2 INT NOT NULL,
    Grade_3 INT NOT NULL,
    Grade_4 INT NOT NULL,
    Grade_5 INT NOT NULL,
    Grade_6 INT NOT NULL,
    Grade_7 INT NOT NULL,
    Grade_8 INT NOT NULL,
    Grade_9 INT NOT NULL,
    Total INT NOT NULL,
    FOREIGN KEY (CountryID) REFERENCES Countries(CountryID)
);

CREATE TABLE SubjectsLimits (
    StatID INT PRIMARY KEY AUTO_INCREMENT,
    SubjectID INT,
    GradeID INT,
    MinH INT NOT NULL,
    MaxH INT NOT NULL,
    AvgH INT NOT NULL,
    FOREIGN KEY (SubjectID) REFERENCES Subjects(SubjectID),
    FOREIGN KEY (GradeID) REFERENCES GradeLevels(GradeID)
);

CREATE TABLE TeachingHours (
    RecordID INT PRIMARY KEY AUTO_INCREMENT,
    CountryID INT,
    SubjectID INT,
    GradeID INT,
    AnnualHours INT,
    RelativeWeight INT,
    FOREIGN KEY (CountryID) REFERENCES Countries(CountryID),
    FOREIGN KEY (SubjectID) REFERENCES Subjects(SubjectID),
    FOREIGN KEY (GradeID) REFERENCES GradeLevels(GradeID)
);

CREATE TABLE jobs (
    jobID INT PRIMARY KEY,
    job VARCHAR(50),
    job_ar VARCHAR(50)
);

CREATE TABLE users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    jobID INT,
    FOREIGN KEY (jobID) REFERENCES jobs(jobID) ON DELETE SET NULL
);

-- Insert jobs
INSERT INTO jobs (jobID, job, job_ar) VALUES
    (1, 'Teacher', 'مدرس'),
    (2, 'School Principal', 'مدير مدرسة'),
    (3, 'Subject Supervisor', 'موجه المادة'),
    (4, 'Local Authority Official', 'مسؤول المنطقة التعليمية'),
    (5, 'Ministry Official', 'مسؤول وزاري');

-- Insert User
INSERT INTO users (user_email, password, jobID) VALUES
("mohamed@gaserc.edu", "1a3de3468f778eb7960e8bb5c44765eb1d89c473be341e16b8992fbc877c8ded", 5);

-- Insert Countries Names
INSERT INTO Countries (CountryID, Country, Country_ar) VALUES
(1, 'United Arab Emirates', 'الامارات'),
(2, 'Bahrain', 'البحرين'),
(3, 'Saudi Arabia', 'السعودية'),
(4, 'Oman', 'عمان'),
(5, 'Qatar', 'قطر'),
(6, 'Kuwait', 'الكويت'),
(7, 'Yemen', 'اليمن');

-- Insert Grades
INSERT INTO GradeLevels (GradeID, Grade, Grade_ar) VALUES
(1, 1, 'الأول'),
(2, 2, 'الثاني'),
(3, 3, 'الثالث'),
(4, 4, 'الرابع'),
(5, 5, 'الخامس'),
(6, 6, 'السادس'),
(7, 7, 'السابع'),
(8, 8, 'الثامن'),
(9, 9, 'التاسع');

-- Insert Subjects
INSERT INTO Subjects (SubjectID, Subject, Subject_ar) VALUES
(1, 'Arabic Language', 'اللغة العربية'),
(2, 'English Language', 'اللغة الإنجليزية'),
(3, 'Mathematics', 'الرياضيات'),
(4, 'Science', 'العلوم'),
(5, 'Social Studies', 'الدراسات الاجتماعية'),
(6, 'Islamic Education', 'التربية الإسلامية'),
(7, 'Physical Education', 'التربية البدنية'),
(8, 'Arts', 'الفنون'),
(9, 'Music/Art Education', 'الموسيقى/ التربية الفنية'),
(10, 'Art Education', 'التربية الفنية'),
(11, 'Fine Arts', 'الفنون التشكيلية'),
(12, 'Visual Arts', 'الفنون البصرية'),
(13, 'Musical Skills', 'المهارات الموسيقية'),
(14, 'Musical Education', 'التربية الموسيقية'),
(15, 'Computing, creative design and innovation', 'الحوسبة والتصميم الإبداعي والابتكار'),
(16, 'Information Technology / Design and Technology / (Family Education (Life Skills))', 'تقنية المعلومات/ التصميم والتقانة/ (التربية الأسرية (مهارات الحياة)'),
(17, 'Digital skills', 'المهارات الرقمية'),
(18, 'Information technology', 'تقنية المعلومات'),
(19, 'Computing and information technology', 'الحوسبة وتكنولوجيا المعلومات'),
(20, 'Computer', 'الحاسب الآلى'),
(21, 'Moral Education', 'التربية الأخلاقية'),
(22, 'Recitation', 'التلاوة'),
(23, 'Critical thinking', 'التفكير الناقد'),
(24, 'Career guidance service', 'خدمة التوجيه المهني'),
(25, 'Activities', 'الأنشطة'),
(26, 'Family Sciences', 'علوم الأسرة'),
(27, 'Vocational education', 'تربية مهنية'),
(28, 'Citizenship Education', 'التربية للمواطنة'),
(29, 'Life and family skills', 'المهارات الحياتية والأسرية'),
(30, 'Practical studies (decoration and electricity)', 'دراسات عملية (ديكور وكهرباء)'),
(31, 'Holy Quran', 'قرآن كريم'),
(32, 'Business Administration', 'إدارة الأعمال'),
(33, 'ATHS', 'ثانوية التكنولوجيا التطبيقية'),
(34, 'Quran Recitation and Islamic Studies', 'القرآن الكريم والدراسات الإسلامية'),
(35, 'Life Skills', 'المهارات الحياتية');

-- Insert Countries Data
INSERT INTO CountriesData (CountryID, no_weeks, minutes, Grade_1, Grade_2, Grade_3, Grade_4, Grade_5, Grade_6, Grade_7, Grade_8, Grade_9, Total)
VALUES
(1, 38, 45, 998, 998, 998, 998, 1140, 1140, 1140, 1140, 1140, 9263),
(2, 38, 45, 855, 855, 855, 855, 855, 855, 941, 941, 941, 7952),
(3, 38, 45, 855, 855, 855, 884, 884, 884, 969, 969, 969, 8123),
(4, 33, 40, 880, 880, 880, 880, 880, 880, 880, 880, 880, 7920),
(5, 34, 44, 842, 848, 848, 848, 848, 848, 848, 842, 842, 7611),
(6, 38, 45, 770, 770, 770, 798, 798, 969, 969, 969, 969, 7781),
(7, 32, 35, 541, 541, 560, 635, 691, 691, 728, 728, 709, 5824);

-- Insert Subjects Limits
INSERT INTO SubjectsLimits (SubjectID, GradeID, MinH, MaxH, AvgH) VALUES
    (1, 1, 22, 40, 25),    -- Arabic, Primary
    (1, 7, 12, 22, 15),    -- Arabic, Middle
    (2, 1, 3, 13, 6),      -- English, Primary
    (2, 7, 8, 12, 10),     -- English, Middle
    (3, 1, 13, 24, 17),    -- Math, Primary
    (3, 7, 12, 16, 13),    -- Math, Middle
    (4, 1, 4, 10, 7),      -- Science, Primary
    (4, 7, 8, 20, 12),     -- Science, Middle
    (5, 1, 3, 13, 6),      -- Social Studies, Primary
    (5, 7, 5, 15, 11),     -- Social Studies, Middle
    (6, 1, 1, 10, 5),      -- Islamic Education, Primary
    (6, 7, 3, 8, 4),       -- Islamic Education, Middle
    (7, 1, 4, 14, 9),      -- Physical Education, Primary
    (7, 7, 5, 14, 8),      -- Physical Education, Middle
    (8, 1, 5, 16, 10),     -- Art, Primary
    (8, 7, 4, 8, 7);       -- Art, Middle

-- Insert Countries Teaching Hours
INSERT INTO TeachingHours (CountryID, SubjectID, GradeID, AnnualHours, RelativeWeight) VALUES
-- Insert Teaching Hours for United Arab Emirates
-- Moral Education (التربية الأخلاقية)
(1, 21, 1, 29, 3),
(1, 21, 2, 29, 3),
(1, 21, 3, 29, 3),
(1, 21, 4, 29, 3),
(1, 21, 5, 29, 3),
(1, 21, 6, 29, 3),
(1, 21, 7, 29, 3),
(1, 21, 8, 29, 3),
(1, 21, 9, 0, 0),

-- Arabic Language (اللغة العربية)
(1, 1, 1, 200, 20),
(1, 1, 2, 200, 20),
(1, 1, 3, 143, 14),
(1, 1, 4, 143, 14),
(1, 1, 5, 143, 14),
(1, 1, 6, 86, 8),
(1, 1, 7, 86, 8),
(1, 1, 8, 86, 8),
(1, 1, 9, 143, 14),

-- Islamic Education (التربية الإسلامية)
(1, 6, 1, 86, 9),
(1, 6, 2, 86, 9),
(1, 6, 3, 86, 9),
(1, 6, 4, 86, 9),
(1, 6, 5, 86, 9),
(1, 6, 6, 57, 5),
(1, 6, 7, 57, 5),
(1, 6, 8, 57, 5),
(1, 6, 9, 57, 5),

-- Social Studies (الدراسات الاجتماعية)
(1, 5, 1, 57, 6),
(1, 5, 2, 57, 6),
(1, 5, 3, 57, 6),
(1, 5, 4, 57, 6),
(1, 5, 5, 57, 6),
(1, 5, 7, 143, 13),
(1, 5, 6, 143, 13),
(1, 5, 8, 143, 13),
(1, 5, 9, 57, 6),

-- English Language (اللغة الإنجليزية)
(1, 2, 1, 143, 14),
(1, 2, 2, 143, 14),
(1, 2, 3, 143, 14),
(1, 2, 4, 143, 14),
(1, 2, 5, 171, 15),
(1, 2, 6, 171, 15),
(1, 2, 7, 171, 15),
(1, 2, 8, 171, 15),
(1, 2, 9, 171, 15),

-- Mathematics (الرياضيات)
(1, 6, 1, 171, 17),
(1, 6, 2, 171, 17),
(1, 6, 3, 200, 20),
(1, 6, 4, 200, 20),
(1, 6, 5, 228, 20),
(1, 6, 6, 228, 20),
(1, 6, 7, 228, 20),
(1, 6, 8, 228, 20),
(1, 6, 9, 228, 20),

-- Science (العلوم المتكاملة)
(1, 3, 1, 114, 11),
(1, 3, 2, 114, 11),
(1, 3, 3, 114, 11),
(1, 3, 4, 114, 11),
(1, 3, 5, 171, 15),
(1, 3, 6, 171, 15),
(1, 3, 7, 171, 15),
(1, 3, 8, 171, 15),
(1, 3, 9, 171, 15),

-- Computing, Creative Design, and Innovation (الحوسبة والتصميم الإبداعي والابتكار)
(1, 15, 1, 57, 6),
(1, 15, 2, 57, 6),
(1, 15, 3, 86, 9),
(1, 15, 4, 86, 9),
(1, 15, 5, 86, 8),
(1, 15, 6, 86, 8),
(1, 15, 7, 86, 8),
(1, 15, 8, 86, 8),
(1, 15, 9, 86, 8),

-- Art Education (الفنون)
(1, 8, 1, 57, 6),
(1, 8, 2, 57, 6),
(1, 8, 3, 57, 6),
(1, 8, 4, 57, 6),
(1, 8, 5, 86, 8),
(1, 8, 6, 86, 8),
(1, 8, 7, 86, 8),
(1, 8, 8, 86, 8),
(1, 8, 9, 86, 8),

-- Physical Education and Health (التربية البدنية والصحية)
(1, 7, 1, 86, 9),
(1, 7, 2, 86, 9),
(1, 7, 3, 86, 9),
(1, 7, 4, 86, 9),
(1, 7, 5, 86, 8),
(1, 7, 6, 86, 8),
(1, 7, 7, 86, 8),
(1, 7, 8, 86, 8),
(1, 7, 9, 57, 6),

-- Business Administration (إدارة الأعمال)
(1, 32, 1, 0, 0),
(1, 32, 2, 0, 0),
(1, 32, 3, 0, 0),
(1, 32, 4, 0, 0),
(1, 32, 5, 0, 0),
(1, 32, 6, 0, 0),
(1, 32, 7, 0, 0),
(1, 32, 8, 0, 0),
(1, 32, 9, 86, 8),

-- ATHS (ثانوية التكنولوجيا التطبيقية)
(1, 33, 1, 0, 0),
(1, 33, 2, 0, 0),
(1, 33, 3, 0, 0),
(1, 33, 4, 0, 0),
(1, 33, 5, 0, 0),
(1, 33, 6, 0, 0),
(1, 33, 7, 0, 0),
(1, 33, 8, 0, 0),
(1, 33, 9, 143, 14),



-- Insert Teaching Hours for Bahrain
-- Arabic Language (اللغة العربية)
(2, 1, 1, 171, 20),
(2, 1, 2, 171, 20),
(2, 1, 3, 171, 20),
(2, 1, 4, 171, 20),
(2, 1, 5, 171, 20),
(2, 1, 6, 171, 18),
(2, 1, 7, 171, 18),
(2, 1, 8, 171, 18),
(2, 1, 9, 171, 19),

-- English Language (اللغة الإنجليزية)
(2, 2, 1, 143, 17),
(2, 2, 2, 143, 17),
(2, 2, 3, 143, 17),
(2, 2, 4, 143, 17),
(2, 2, 5, 143, 17),
(2, 2, 6, 143, 15),
(2, 2, 7, 143, 15),
(2, 2, 8, 143, 15),
(2, 2, 9, 143, 16),

-- Mathematics (الرياضيات)
(2, 3, 1, 171, 20),
(2, 3, 2, 171, 20),
(2, 3, 3, 171, 20),
(2, 3, 4, 171, 20),
(2, 3, 5, 171, 20),
(2, 3, 6, 171, 18),
(2, 3, 7, 171, 18),
(2, 3, 8, 171, 18),
(2, 3, 9, 171, 19),

-- Science (العلوم)
(2, 4, 1, 86, 10),
(2, 4, 2, 86, 10),
(2, 4, 3, 86, 10),
(2, 4, 4, 86, 10),
(2, 4, 5, 86, 10),
(2, 4, 6, 114, 12),
(2, 4, 7, 114, 12),
(2, 4, 8, 114, 12),
(2, 4, 9, 114, 11),

-- Islamic Education (التربية الإسلامية)
(2, 6, 1, 86, 10),
(2, 6, 2, 86, 10),
(2, 6, 3, 86, 10),
(2, 6, 4, 57, 7),
(2, 6, 5, 57, 7),
(2, 6, 6, 86, 9),
(2, 6, 7, 86, 9),
(2, 6, 8, 86, 9),
(2, 6, 9, 86, 8),

-- Citizenship Education (التربية للمواطنة)
(2, 28, 1, 29, 3),
(2, 28, 2, 29, 3),
(2, 28, 3, 29, 3),
(2, 28, 4, 29, 3),
(2, 28, 5, 29, 3),
(2, 28, 6, 29, 3),
(2, 28, 7, 29, 3),
(2, 28, 8, 29, 3),
(2, 28, 9, 29, 3),

-- Social Studies (المواد الاجتماعية)
(2, 5, 1, 0, 0),
(2, 5, 2, 0, 0),
(2, 5, 3, 0, 0),
(2, 5, 4, 29, 3),
(2, 5, 5, 29, 3),
(2, 5, 6, 29, 3),
(2, 5, 7, 86, 9),
(2, 5, 8, 86, 9),
(2, 5, 9, 86, 9),

-- Physical Education (التربية الرياضية)
(2, 7, 1, 57, 7),
(2, 7, 2, 57, 7),
(2, 7, 3, 57, 7),
(2, 7, 4, 57, 7),
(2, 7, 5, 57, 7),
(2, 7, 6, 57, 6),
(2, 7, 7, 57, 6),
(2, 7, 8, 57, 6),
(2, 7, 9, 57, 6),

-- IT/Creative Design/Technology (تقنية المعلومات/ التصميم والتقانة/ التربية الأسرية)
(2, 16, 1, 57, 7),
(2, 16, 2, 57, 7),
(2, 16, 3, 57, 7),
(2, 16, 4, 57, 7),
(2, 16, 5, 57, 7),
(2, 16, 6, 57, 6),
(2, 16, 7, 57, 6),
(2, 16, 8, 57, 6),
(2, 16, 9, 57, 6),

-- Music/Art (الموسيقى/ التربية الفنية)
(2, 9, 1, 57, 7),
(2, 9, 2, 57, 7),
(2, 9, 3, 57, 7),
(2, 9, 4, 57, 7),
(2, 9, 5, 57, 7),
(2, 9, 6, 29, 3),
(2, 9, 7, 29, 3),
(2, 9, 8, 29, 3),
(2, 9, 9, 29, 3),



-- Insert Teaching Hours for Saudi Arabia
-- Quran Recitation and Islamic Studies (القرآن الكريم والدراسات الإسلامية)
(3, 6, 1, 143, 17),
(3, 6, 2, 143, 17),
(3, 6, 3, 143, 17),
(3, 6, 4, 143, 16),
(3, 6, 5, 143, 16),
(3, 6, 6, 143, 16),
(3, 6, 7, 143, 16),
(3, 6, 8, 143, 16),
(3, 6, 9, 143, 15),

-- Arabic Language (اللغة العربية)
(3, 1, 1, 228, 27),
(3, 1, 2, 200, 23),
(3, 1, 3, 171, 20),
(3, 1, 4, 143, 16),
(3, 1, 5, 143, 16),
(3, 1, 6, 143, 16),
(3, 1, 7, 143, 15),
(3, 1, 8, 143, 15),
(3, 1, 9, 114, 12),

-- Social Studies (الدراسات الاجتماعية)
(3, 5, 1, 0, 0),
(3, 5, 2, 0, 0),
(3, 5, 3, 0, 0),
(3, 5, 4, 57, 6),
(3, 5, 5, 57, 6),
(3, 5, 6, 57, 6),
(3, 5, 7, 86, 9),
(3, 5, 8, 86, 9),
(3, 5, 9, 57, 6),

-- Mathematics (الرياضيات)
(3, 3, 1, 143, 17),
(3, 3, 2, 171, 20),
(3, 3, 3, 171, 20),
(3, 3, 4, 171, 19),
(3, 3, 5, 171, 19),
(3, 3, 6, 171, 19),
(3, 3, 7, 171, 18),
(3, 3, 8, 171, 18),
(3, 3, 9, 171, 18),

-- Science (العلوم)
(3, 4, 1, 86, 10),
(3, 4, 2, 86, 10),
(3, 4, 3, 114, 13),
(3, 4, 4, 114, 13),
(3, 4, 5, 114, 13),
(3, 4, 6, 114, 13),
(3, 4, 7, 114, 12),
(3, 4, 8, 114, 12),
(3, 4, 9, 114, 12),

-- English Language (اللغة الإنجليزية)
(3, 2, 1, 86, 10),
(3, 2, 2, 86, 10),
(3, 2, 3, 86, 10),
(3, 2, 4, 86, 10),
(3, 2, 5, 86, 10),
(3, 2, 6, 86, 10),
(3, 2, 7, 114, 10),
(3, 2, 8, 114, 12),
(3, 2, 9, 114, 12),

-- Digital Skills (المهارات الرقمية)
(3, 17, 1, 0, 0),
(3, 17, 2, 0, 0),
(3, 17, 3, 0, 0),
(3, 17, 4, 57, 6),
(3, 17, 5, 57, 6),
(3, 17, 6, 57, 6),
(3, 17, 7, 57, 6),
(3, 17, 8, 57, 6),
(3, 17, 9, 57, 6),

-- Arts (التربية الفنية)
(3, 10, 1, 57, 7),
(3, 10, 2, 57, 7),
(3, 10, 3, 57, 7),
(3, 10, 4, 29, 3),
(3, 10, 5, 29, 3),
(3, 10, 6, 29, 3),
(3, 10, 7, 57, 6),
(3, 10, 8, 57, 6),
(3, 10, 9, 57, 6),

-- Physical Education and Self-Defense (التربية البدنية والدفاع عن النفس)
(3, 7, 1, 86, 10),
(3, 7, 2, 86, 10),
(3, 7, 3, 86, 10),
(3, 7, 4, 57, 6),
(3, 7, 5, 57, 6),
(3, 7, 6, 57, 6),
(3, 7, 7, 57, 6),
(3, 7, 8, 57, 6),
(3, 7, 9, 57, 6),

-- Critical Thinking (التفكير الناقد)
(3, 23, 1, 0, 1),
(3, 23, 2, 0, 1),
(3, 23, 3, 0, 0),
(3, 23, 4, 0, 0),
(3, 23, 5, 0, 0),
(3, 23, 6, 0, 0),
(3, 23, 7, 0, 0),
(3, 23, 8, 0, 0),
(3, 23, 9, 57, 6),

-- Life and Family Skills (المهارات الحياتية والأسرية)
(3, 29, 1, 29, 3),
(3, 29, 2, 29, 3),
(3, 29, 3, 29, 3),
(3, 29, 4, 29, 3),
(3, 29, 5, 29, 3),
(3, 29, 6, 29, 3),
(3, 29, 7, 29, 3),
(3, 29, 8, 29, 3),
(3, 29, 9, 29, 3),



-- Insert Teaching Hours for Oman
-- Islamic Education (التربية الإسلامية)
(4, 6, 1, 110, 13),
(4, 6, 2, 110, 13),
(4, 6, 3, 110, 13),
(4, 6, 4, 110, 13),
(4, 6, 5, 110, 13),
(4, 6, 6, 110, 13),
(4, 6, 7, 110, 13),
(4, 6, 8, 110, 13),
(4, 6, 9, 110, 13),

-- Arabic Language (اللغة العربية)
(4, 1, 1, 264, 30),
(4, 1, 2, 264, 30),
(4, 1, 3, 220, 25),
(4, 1, 4, 154, 18),
(4, 1, 5, 154, 18),
(4, 1, 6, 154, 18),
(4, 1, 7, 154, 18),
(4, 1, 8, 154, 18),
(4, 1, 9, 154, 18),

-- English Language (اللغة الإنجليزية)
(4, 2, 1, 154, 18),
(4, 2, 2, 154, 18),
(4, 2, 3, 154, 18),
(4, 2, 4, 110, 13),
(4, 2, 5, 110, 13),
(4, 2, 6, 110, 13),
(4, 2, 7, 110, 13),
(4, 2, 8, 110, 13),
(4, 2, 9, 110, 13),

-- Social Studies (الدراسات الاجتماعية)
(4, 5, 1, 66, 8),
(4, 5, 2, 66, 8),
(4, 5, 3, 66, 8),
(4, 5, 4, 88, 10),
(4, 5, 5, 88, 10),
(4, 5, 6, 88, 10),
(4, 5, 7, 88, 10),
(4, 5, 8, 44, 5),
(4, 5, 9, 44, 5),

-- Mathematics (الرياضيات)
(4, 3, 1, 132, 15),
(4, 3, 2, 132, 15),
(4, 3, 3, 132, 15),
(4, 3, 4, 132, 15),
(4, 3, 5, 154, 18),
(4, 3, 6, 154, 18),
(4, 3, 7, 154, 18),
(4, 3, 8, 154, 18),
(4, 3, 9, 132, 15),

-- Science (العلوم)
(4, 4, 1, 66, 8),
(4, 4, 2, 66, 8),
(4, 4, 3, 66, 8),
(4, 4, 4, 110, 13),
(4, 4, 5, 110, 13),
(4, 4, 6, 110, 13),
(4, 4, 7, 132, 15),
(4, 4, 8, 132, 15),
(4, 4, 9, 198, 18),

-- Life Skills (المهارات الحياتية)
(4, 35, 1, 22, 3),
(4, 35, 2, 22, 3),
(4, 35, 3, 22, 3),
(4, 35, 4, 22, 3),
(4, 35, 5, 22, 3),
(4, 35, 6, 22, 3),
(4, 35, 7, 22, 3),
(4, 35, 8, 22, 3),
(4, 35, 9, 22, 3),

-- Information Technology (تقنية المعلومات)
(4, 18, 1, 22, 3),
(4, 18, 2, 22, 3),
(4, 18, 3, 22, 3),
(4, 18, 4, 22, 3),
(4, 18, 5, 44, 5),
(4, 18, 6, 44, 5),
(4, 18, 7, 44, 5),
(4, 18, 8, 44, 5),
(4, 18, 9, 22, 3),

-- Physical Education (التربية البدنية والصحية)
(4, 7, 1, 44, 5),
(4, 7, 2, 44, 5),
(4, 7, 3, 44, 5),
(4, 7, 4, 44, 5),
(4, 7, 5, 44, 5),
(4, 7, 6, 44, 5),
(4, 7, 7, 22, 3),
(4, 7, 8, 22, 3),
(4, 7, 9, 22, 3),

-- Art Education (الفنون التشكيلية)
(4, 11, 1, 44, 5),
(4, 11, 2, 44, 5),
(4, 11, 3, 44, 5),
(4, 11, 4, 44, 5),
(4, 11, 5, 44, 5),
(4, 11, 6, 44, 5),
(4, 11, 7, 22, 3),
(4, 11, 8, 22, 3),
(4, 11, 9, 22, 3),

-- Music Skills (المهارات الموسيقية)
(4, 13, 1, 22, 3),
(4, 13, 2, 22, 3),
(4, 13, 3, 22, 3),
(4, 13, 4, 22, 3),
(4, 13, 5, 22, 3),
(4, 13, 6, 22, 3),
(4, 13, 7, 22, 3),
(4, 13, 8, 22, 3),
(4, 13, 9, 22, 3),

-- Career Guidance Service (خدمة التوجيه المهني)
(4, 24, 1, 0, 0),
(4, 24, 2, 0, 0),
(4, 24, 3, 0, 0),
(4, 24, 4, 0, 0),
(4, 24, 5, 0, 0),
(4, 24, 6, 0, 0),
(4, 24, 7, 0, 0),
(4, 24, 8, 0, 0),
(4, 24, 9, 22, 3),



-- Insert Teaching Hours for Qatar
-- Islamic Education (التربية الإسلامية)
(5, 6, 1, 75, 9),
(5, 6, 2, 75, 9),
(5, 6, 3, 100, 12),
(5, 6, 4, 100, 12),
(5, 6, 5, 100, 12),
(5, 6, 6, 100, 12),
(5, 6, 7, 102, 12),
(5, 6, 8, 102, 12),
(5, 3, 9, 102, 12),

-- Arabic Language (اللغة العربية)
(5, 1, 1, 249, 30),
(5, 1, 2, 224, 26),
(5, 1, 3, 175, 21),
(5, 1, 4, 175, 21),
(5, 1, 5, 150, 18),
(5, 1, 6, 150, 18),
(5, 1, 7, 128, 15),
(5, 1, 8, 128, 15),
(5, 1, 9, 128, 15),

-- English Language (اللغة الإنجليزية)
(5, 2, 1, 125, 15),
(5, 2, 2, 125, 15),
(5, 2, 3, 125, 15),
(5, 2, 4, 125, 15),
(5, 2, 5, 125, 15),
(5, 2, 6, 125, 15),
(5, 2, 7, 128, 15),
(5, 2, 8, 128, 15),
(5, 2, 9, 128, 15),

-- Mathematics (الرياضيات)
(5, 3, 1, 199, 24),
(5, 3, 2, 175, 21),
(5, 3, 3, 150, 18),
(5, 3, 4, 150, 18),
(5, 3, 5, 150, 18),
(5, 3, 6, 150, 18),
(5, 3, 7, 128, 15),
(5, 3, 8, 128, 15),
(5, 3, 9, 128, 15),

-- Science (العلوم)
(5, 4, 1, 100, 12),
(5, 4, 2, 100, 12),
(5, 4, 3, 75, 9),
(5, 4, 4, 75, 9),
(5, 4, 5, 75, 9),
(5, 4, 6, 75, 9),
(5, 4, 7, 102, 12),
(5, 4, 8, 102, 12),
(5, 4, 9, 102, 12),

-- Social Studies (الدراسات الاجتماعية)
(5, 5, 1, 0, 0),
(5, 5, 2, 0, 0),
(5, 5, 3, 50, 6),
(5, 5, 4, 50, 6),
(5, 5, 5, 75, 9),
(5, 5, 6, 75, 9),
(5, 5, 7, 77, 9),
(5, 5, 8, 77, 9),
(5, 5, 9, 77, 9),

-- Computing and IT (الحوسبة وتكنولوجيا المعلومات)
(5, 19, 1, 50, 6),
(5, 19, 2, 50, 6),
(5, 19, 3, 50, 6),
(5, 19, 4, 50, 6),
(5, 19, 5, 50, 6),
(5, 19, 6, 50, 6),
(5, 19, 7, 51, 6),
(5, 19, 8, 51, 6),
(5, 19, 9, 51, 6),

-- Physical Education (التربية البدنية)
(5, 7, 1, 50, 6),
(5, 7, 2, 50, 6),
(5, 7, 3, 50, 6),
(5, 7, 4, 50, 6),
(5, 7, 5, 50, 6),
(5, 7, 6, 50, 6),
(5, 7, 7, 51, 6),
(5, 7, 8, 51, 6),
(5, 7, 9, 51, 6),

-- Visual Arts (الفنون البصرية)
(5, 12, 1, 50, 6),
(5, 12, 2, 50, 6),
(5, 12, 3, 50, 6),
(5, 12, 4, 50, 6),
(5, 12, 5, 50, 6),
(5, 12, 6, 50, 6),
(5, 12, 7, 51, 6),
(5, 12, 8, 51, 6),
(5, 12, 9, 51, 6),

-- Activities (الأنشطة)
(5, 25, 1, 0, 0),
(5, 25, 2, 0, 0),
(5, 25, 3, 0, 0),
(5, 25, 4, 0, 0),
(5, 25, 5, 0, 0),
(5, 25, 6, 0, 0),
(5, 25, 7, 26, 6),
(5, 25, 8, 26, 6),
(5, 25, 9, 26, 6),



-- Insert Teaching Hours for Kuwait
-- Quran (القرآن الكريم)
(6, 31, 1, 57, 7),
(6, 31, 2, 57, 7),
(6, 31, 3, 29, 3),
(6, 31, 4, 29, 3),
(6, 31, 5, 29, 3),
(6, 31, 6, 29, 3),
(6, 31, 7, 29, 3),
(6, 31, 8, 29, 3),
(6, 31, 9, 29, 3),

-- Islamic Education (التربية الإسلامية)
(6, 6, 1, 57, 7),
(6, 6, 2, 57, 7),
(6, 6, 3, 57, 7),
(6, 6, 4, 57, 7),
(6, 6, 5, 57, 7),
(6, 6, 6, 57, 7),
(6, 6, 7, 57, 7),
(6, 6, 8, 57, 7),
(6, 6, 9, 57, 7),

-- Arabic Language (اللغة العربية)
(6, 1, 1, 257, 33),
(6, 1, 2, 257, 33),
(6, 1, 3, 200, 25),
(6, 1, 4, 200, 25),
(6, 1, 5, 171, 18),
(6, 1, 6, 171, 18),
(6, 1, 7, 171, 18),
(6, 1, 8, 171, 18),
(6, 1, 9, 171, 18),

-- English Language (اللغة الإنجليزية)
(6, 2, 1, 114, 14),
(6, 2, 2, 114, 14),
(6, 2, 3, 171, 18),
(6, 2, 4, 171, 18),
(6, 2, 5, 171, 18),
(6, 2, 6, 171, 18),
(6, 2, 7, 171, 18),
(6, 2, 8, 171, 18),
(6, 2, 9, 171, 18),

-- Mathematics (الرياضيات)
(6, 3, 1, 143, 18),
(6, 3, 2, 143, 18),
(6, 3, 3, 143, 18),
(6, 3, 4, 143, 18),
(6, 3, 5, 143, 18),
(6, 3, 6, 143, 18),
(6, 3, 7, 143, 18),
(6, 3, 8, 143, 18),
(6, 3, 9, 143, 18),

-- Science (العلوم)
(6, 4, 1, 57, 7),
(6, 4, 2, 57, 7),
(6, 4, 3, 114, 12),
(6, 4, 4, 114, 12),
(6, 4, 5, 114, 12),
(6, 4, 6, 114, 12),
(6, 4, 7, 114, 12),
(6, 4, 8, 114, 12),
(6, 4, 9, 114, 12),

-- Social Studies (الاجتماعيات)
(6, 5, 1, 0, 0),
(6, 5, 2, 0, 0),
(6, 5, 3, 0, 0),
(6, 5, 4, 57, 7),
(6, 5, 5, 57, 7),
(6, 5, 6, 57, 7),
(6, 5, 7, 57, 7),
(6, 5, 8, 57, 7),
(6, 5, 9, 57, 7),

-- Computer Science (الحاسب الآلى)
(6, 20, 1, 57, 6),
(6, 20, 2, 57, 6),
(6, 20, 3, 86, 9),
(6, 20, 4, 86, 8),
(6, 20, 5, 86, 8),
(6, 20, 6, 86, 8),
(6, 20, 7, 0, 8),
(6, 20, 8, 86, 8),
(6, 20, 9, 86, 8),

-- Physical Education (التربية البدنية)
(6, 7, 1, 86, 11),
(6, 7, 2, 86, 11),
(6, 7, 3, 57, 7),
(6, 7, 4, 57, 7),
(6, 7, 5, 57, 7),
(6, 7, 6, 57, 7),
(6, 7, 7, 57, 7),
(6, 7, 8, 57, 7),
(6, 7, 9, 57, 7),

-- Art Education (التربية الفنية)
(6, 10, 1, 57, 7),
(6, 10, 2, 57, 7),
(6, 10, 3, 57, 7),
(6, 10, 4, 57, 7),
(6, 10, 5, 57, 7),
(6, 10, 6, 57, 7),
(6, 10, 7, 57, 7),
(6, 10, 8, 57, 7),
(6, 10, 9, 57, 7),

-- Music Education (التربية الموسيقية)
(6, 14, 1, 29, 3),
(6, 14, 2, 29, 3),
(6, 14, 3, 29, 3),
(6, 14, 4, 29, 3),
(6, 14, 5, 29, 3),
(6, 14, 6, 29, 3),
(6, 14, 7, 29, 3),
(6, 14, 8, 29, 3),
(6, 14, 9, 29, 3),

-- Family Science (علوم الأسرة)
(6, 26, 1, 0, 0),
(6, 26, 2, 0, 0),
(6, 26, 3, 57, 7),
(6, 26, 4, 57, 7),
(6, 26, 5, 57, 7),
(6, 26, 6, 57, 7),
(6, 26, 7, 0, 0),
(6, 26, 8, 0, 0),
(6, 26, 9, 0, 0),

-- Practical Studies (دراسات عملية)
(6, 30, 1, 0, 0),
(6, 30, 2, 0, 0),
(6, 30, 3, 29, 3),
(6, 30, 4, 29, 3),
(6, 30, 5, 29, 3),
(6, 30, 6, 29, 3),
(6, 30, 7, 0, 0),
(6, 30, 8, 0, 0),
(6, 30, 9, 0, 0),



-- Insert Teaching Hours for Yemen
-- Quran (قرآن كريم)
(7, 31, 1, 93, 17),
(7, 31, 2, 93, 17),
(7, 31, 3, 75, 12),
(7, 31, 4, 75, 11),
(7, 31, 5, 75, 11),
(7, 31, 6, 56, 8),
(7, 31, 7, 56, 8),
(7, 31, 8, 56, 8),
(7, 31, 9, 56, 8),

-- Islamic Education (تربية إسلامية)
(7, 6, 1, 56, 10),
(7, 6, 2, 56, 10),
(7, 6, 3, 75, 11),
(7, 6, 4, 75, 11),
(7, 6, 5, 75, 11),
(7, 6, 6, 75, 11),
(7, 6, 7, 75, 11),
(7, 6, 8, 75, 11),
(7, 6, 9, 75, 11),

-- Arabic Language (لغة عربية)
(7, 1, 1, 187, 35),
(7, 1, 2, 187, 35),
(7, 1, 3, 168, 24),
(7, 1, 4, 168, 24),
(7, 1, 5, 112, 16),
(7, 1, 6, 112, 16),
(7, 1, 7, 112, 16),
(7, 1, 8, 112, 16),
(7, 1, 9, 112, 16),

-- English Language (لغة إنجليزية)
(7, 2, 1, 0, 0),
(7, 2, 2, 0, 0),
(7, 2, 3, 93, 13),
(7, 2, 4, 93, 13),
(7, 2, 5, 93, 13),
(7, 2, 6, 0, 0),
(7, 2, 7, 0, 0),
(7, 2, 8, 0, 0),
(7, 2, 9, 0, 0),

-- Mathematics (رياضيات)
(7, 3, 1, 93, 17),
(7, 3, 2, 93, 17),
(7, 3, 3, 168, 24),
(7, 3, 4, 168, 24),
(7, 3, 5, 168, 24),
(7, 3, 6, 168, 24),
(7, 3, 7, 168, 24),
(7, 3, 8, 168, 24),
(7, 3, 9, 168, 24),

-- Science (علوم)
(7, 4, 1, 37, 7),
(7, 4, 2, 37, 7),
(7, 4, 3, 56, 8),
(7, 4, 4, 75, 11),
(7, 4, 5, 75, 11),
(7, 4, 6, 75, 11),
(7, 4, 7, 75, 11),
(7, 4, 8, 75, 11),
(7, 4, 9, 75, 11),

-- Social Studies (اجتماعيات)
(7, 5, 1, 0, 0),
(7, 5, 2, 0, 0),
(7, 5, 3, 93, 13),
(7, 5, 4, 93, 13),
(7, 5, 5, 93, 13),
(7, 5, 6, 93, 13),
(7, 5, 7, 93, 13),
(7, 5, 8, 93, 13),
(7, 5, 9, 93, 13),

-- Physical Education (تربية رياضية)
(7, 7, 1, 37, 7),
(7, 7, 2, 37, 7),
(7, 7, 3, 19, 3),
(7, 7, 4, 19, 3),
(7, 7, 5, 19, 3),
(7, 7, 6, 19, 3),
(7, 7, 7, 19, 3),
(7, 7, 8, 19, 3),
(7, 7, 9, 19, 3),

-- Art Education (تربية فنية)
(7, 10, 1, 37, 7),
(7, 10, 2, 37, 7),
(7, 10, 3, 19, 3),
(7, 10, 4, 19, 3),
(7, 10, 5, 19, 3),
(7, 10, 6, 19, 3),
(7, 10, 7, 19, 3),
(7, 10, 8, 19, 3),
(7, 10, 9, 19, 3),

-- Vocational Education (تربية مهنية)
(7, 27, 1, 0, 0),
(7, 27, 2, 0, 0),
(7, 27, 3, 19, 3),
(7, 27, 4, 19, 3),
(7, 27, 5, 19, 3),
(7, 27, 6, 19, 3),
(7, 27, 7, 19, 3),
(7, 27, 8, 19, 3),
(7, 27, 9, 0, 0);