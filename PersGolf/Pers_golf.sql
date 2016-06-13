create database mingolf;
use mingolf;

DROP TABLE IF EXISTS User;

CREATE TABLE User
( Id int NOT NULL AUTO_INCREMENT,
  Username  varchar(30),
  Golfclub VARCHAR(30) NOT NULL,
  Handicap DECIMAL(3,1) NOT NULL,
  Primary key (Id) 
) ENGINE INNODB CHARACTER SET utf8;

insert into User (Username,Golfclub,Handicap) values('Per Sundberg','Ågesta gk',19.5);
select * from User;

CREATE TABLE Calender
( Id int NOT NULL AUTO_INCREMENT,
  Date  DATETIME,
  Activity VARCHAR(300) NOT NULL,
  Primary key (Id) 
) ENGINE INNODB CHARACTER SET utf8;

insert into Calender (Date,Activity) values(NOW(),'Dagens aktitivet');
select * from Calender;

CREATE TABLE Thought
( Id int NOT NULL AUTO_INCREMENT,
  Date  DATETIME,
  Category VARCHAR(30) NOT NULL,
  Activity VARCHAR(300) NOT NULL, 
  Primary key (Id) 
) ENGINE INNODB CHARACTER SET utf8;

insert into Thought (Date,Category,Activity) values(NOW(),'Puttning','Putta med armbågarna ihop');
select * from Thought;

CREATE TABLE Course
( Id int NOT NULL AUTO_INCREMENT,
  Date  DATETIME,
  Course VARCHAR(50) NOT NULL,
  Information VARCHAR(100) NOT NULL, 
  Primary key (Id) 
) ENGINE INNODB CHARACTER SET utf8;

insert into Course (Date,Course,Information) values(NOW(),'Ågest 9 hål','35 poäng');
select * from Course;

CREATE TABLE Link
( Id int NOT NULL AUTO_INCREMENT,
  Link VARCHAR(50) NOT NULL,
  Description VARCHAR(100) NOT NULL, 
  Primary key (Id) 
) ENGINE INNODB CHARACTER SET utf8;

insert into Link (Link,Description) values('www.golf.se','Golf.se');
select * from Link;

CREATE TABLE Other
( Id int NOT NULL AUTO_INCREMENT,
  Other VARCHAR(50) NOT NULL,
  Primary key (Id) 
) ENGINE INNODB CHARACTER SET utf8;

insert into Other (Other) values('Övrigt');
select * from Other;


CREATE TABLE Question
( Id int NOT NULL AUTO_INCREMENT,
  Questionheader  varchar(50),
  Questionname  varchar(200),
  Primary key (Id)
) ENGINE INNODB CHARACTER SET utf8;

select * from Question;

select Id from Question order by Id desc limit 1;

CREATE TABLE Tag
( Id int NOT NULL AUTO_INCREMENT,
  Tagname  varchar(20),
  Primary key (Id)
) ENGINE INNODB CHARACTER SET utf8;

CREATE TABLE Response
( Id int NOT NULL AUTO_INCREMENT,
  Responseheader  varchar(50),
  Responsename  varchar(200),
  Primary key (Id) 
) ENGINE INNODB CHARACTER SET utf8;

CREATE TABLE Comments
( Id int NOT NULL AUTO_INCREMENT,
  Commentname  varchar(200),
  QuestionResponseType varchar(15),
  QuestionResponseId int,
  UserId int,
  Primary key (Id)
) ENGINE INNODB CHARACTER SET utf8;


select * from Comments where QuestionResponseType='question' and QuestionResponseId=1;

CREATE TABLE UserQuestion
(
  Userid int,
  Questionid int,  
  FOREIGN KEY (Userid) REFERENCES User(Id),
  FOREIGN KEY (Questionid) REFERENCES Question(Id)
) ENGINE INNODB CHARACTER SET utf8;

select * from UserQuestion;

CREATE TABLE UserResponse
(
  Userid int,
  Responseid int,  
  FOREIGN KEY (Userid) REFERENCES User(Id),
  FOREIGN KEY (Responseid) REFERENCES Response(Id)
) ENGINE INNODB CHARACTER SET utf8;

CREATE TABLE QuestionResponse
(
  Questionid int, 
  Responseid int,
  FOREIGN KEY (Questionid) REFERENCES Question(Id),
  FOREIGN KEY (Responseid) REFERENCES Response(Id)
) ENGINE INNODB CHARACTER SET utf8;

CREATE TABLE QuestionTag
(
  Questionid int,
  Tagid int,  
  FOREIGN KEY (Questionid) REFERENCES Question(Id),
  FOREIGN KEY (Tagid) REFERENCES Tag(Id)
) ENGINE INNODB CHARACTER SET utf8;

insert into Tag (Tagname) values('Nybörjare');
insert into Tag (Tagname) values('Teknik');
insert into Tag (Tagname) values('Träning');
insert into Tag (Tagname) values('Tävling');

insert into User (Username,Acronym,Email,Userpassword) values('Per','Pelle','sundberg_p@yahoo.com','pw');
insert into User (Username,Acronym,Email,Userpassword) values('Lars','Lasse','sundberg_l@yahoo.com','pw');

insert into Question (Questionheader,Questionname) values('HeaderFråga1','Fråga1');
insert into Question (Questionheader,Questionname) values('HeaderFråga2','Fråga2');


insert into Response (Responseheader,Responsename) values('SvarHeader2','Svar 2');
insert into Response (Responseheader,Responsename) values('SvarHeader3','Svar 3');

insert into Comments (Commentname,QuestionResponseType,QuestionResponseId) values('Kommentar 1','question',1);
insert into Comments (Commentname,QuestionResponseType,QuestionResponseId) values('Kommentar 2','response',2);


select * from Comments;



insert into UserQuestion values(1,1);

insert into UserQuestion values(2,2);

insert into QuestionTag values(1,1);
insert into QuestionTag values(1,2);
insert into QuestionTag values(2,2);

select * from QuestionTag;

select * from UserQuestion;

insert into UserResponse values(1,2);
insert into UserResponse values(1,3);

insert into UserResponse values(2,2);
insert into UserResponse values(2,3);

insert into QuestionResponse values(1,1);
insert into QuestionResponse values(1,2);

insert into QuestionResponse values(2,2);
insert into QuestionResponse values(2,3);

/**************************************/

/* User 1 has no question */
/* User 2 has question 1 and 2*/
/* User 1 has response 2 */
/* User 2 has response 1 and 2 */
/* Question 1 has response 1 */
/* Question 2 has response 2 and 3 */


select * from Question;
select * from UserQuestion;

insert into Response (Responseheader,Responsename) values('SvarHeader1','Svar 1');
insert into UserResponse values(2,1);
insert into QuestionResponse values(1,1);

insert into Response (Responseheader,Responsename) values('SvarHeader2','Svar 2');
insert into UserResponse values(1,2);
insert into QuestionResponse values(2,2);

insert into Response (Responseheader,Responsename) values('SvarHeader3','Svar 3');
select * from Response;
insert into UserResponse values(2,3);
insert into QuestionResponse values(2,3);
select * from UserResponse;
select * from QuestionResponse;

/*Skapa användare, logga in med användare */


/*Förstasida Most active user*/
select Username from User group by Id order by count(*) desc limit 2;

/*Förstasida Latest questions */
select Questionheader from Question order by Id desc limit 1;

/* Most popular tag */
select Tagname from Tag group by Tagname order by count(*) desc limit 2;

/*Frågesida*/
select Question.Questionheader,User.Username from User,Question,UserQuestion where User.Id=UserQuestion.Userid and Question.Id=UserQuestion.Questionid;
create view VQuestionUser as
select Question.Questionheader,Question.Questionname,User.Username from User,Question,UserQuestion where User.Id=UserQuestion.Userid and Question.Id=UserQuestion.Questionid;

select Question.Questionheader,Tag.Id from Tag,Question,QuestionTag where Tag.Id=QuestionTag.Tagid and Question.Id=QuestionTag.Questionid;

create view VQuestionTag as
select Question.Questionheader,Tag.Id from (Tag join QuestionTag on Tag.Id=QuestionTag.Tagid) join Question on Question.Id=QuestionTag.Questionid;

select Question.Questionheader,User.Username,Tag.Id from User,Question,UserQuestion,Tag,QuestionTag where User.Id=UserQuestion.Userid and Question.Id=UserQuestion.Questionid and Tag.Id=QuestionTag.Tagid and Question.Id=QuestionTag.Questionid;


select VQuestionUser.Questionheader,VQuestionUser.Questionname,VQuestionUser.Username,VQuestionTag.Id from VQuestionUser, VQuestionTag where VQuestionUser.Questionheader=VQuestionTag.Questionheader;


/*SvarSida*/
select User.Username,Response.Responsename from User,Response,UserResponse where User.Id=UserResponse.Userid and Response.Id=UserResponse.Responseid;

select Question.Questionname,Response.Responsename from Question,Response,QuestionResponse where Question.Id=QuestionResponse.Questionid and Response.Id=QuestionResponse.Responseid;

select * from UserResponse;

select UserResponse.Responseid from UserResponse,QuestionResponse where QuestionResponse.Responseid = UserResponse.Responseid and UserResponse.Userid=1;

/* Tagsida */
select VQuestionTag.Id,VQuestionUser.Questionheader,VQuestionUser.Username from VQuestionUser, VQuestionTag where VQuestionUser.Questionheader=VQuestionTag.Questionheader;

select Question.Questionheader,Tag.Tagname from Question,Tag,QuestionTag where Tag.Id=QuestionTag.Tagid and Question.Id=QuestionTag.Questionid and Tag.Id = 1;


/*Användarsida */
select Question.Questionheader from User,Question,UserQuestion where User.Id=UserQuestion.Userid and Question.Id=UserQuestion.Questionid and User.Id=1;
select Question.Questionheader,Question.Questionname from Question where Question.Id=1;
select Response.Responsename from Question,Response,QuestionResponse where Question.Id=QuestionResponse.Questionid and Response.Id=QuestionResponse.Responseid and Question.Id=1;
select Tag.Tagname from Question,Tag,QuestionTag where Question.Id=QuestionTag.Questionid and Tag.Id=QuestionTag.Tagid and Question.Id=1;


select Response.Responseheader from User,Response,UserResponse where User.Id=UserResponse.Userid and Response.Id=UserResponse.Responseid and User.Id=2;

select Question.Questionheader,Question.Questionname,Response.Responsename from Question,Response,QuestionResponse where Question.Id=QuestionResponse.Questionid and Response.Id=QuestionResponse.Responseid and Response.Id=2;




/* Lägga till ny tag*/
insert into Tag (Tagname) values('Tag3');


/* Lägga till ny fråga */
insert into Question (Questionheader,Questionname) values('HeaderFråga4','Fråga4');

select Id from Question where Questionheader='HeaderFråga4';
insert into UserQuestion values(1,4);
select Id from Tag where TagName='Tag3';
insert into QuestionTag values(4,2);
select VQuestionUser.Questionheader,VQuestionUser.Username,VQuestionTag.Id from VQuestionUser, VQuestionTag where VQuestionUser.Questionheader=VQuestionTag.Questionheader;

select Id from Question where Questionheader like 'Fråga 14 </p>%';
select Id from Question where Questionheader like '%Fråga 16</p>%';

/* Lägga till nytt svar*/
insert into Response values(4,'SvarHeader4','Svar 4');
insert into UserResponse values(1,4);
select VQuestionTag.Id,VQuestionUser.Questionheader,VQuestionUser.Username from VQuestionUser, VQuestionTag where VQuestionUser.Questionheader=VQuestionTag.Questionheader;
