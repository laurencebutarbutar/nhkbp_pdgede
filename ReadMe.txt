Fix Page Client - wait for cpanel

## HOW TO RUN APPLICATION ##
1. Create database name : nhkr3131_dbGames, from your phpmyadmin web
2. Import database from db folder name : nhkr3131_dbGames.sql
3. Create new user account from phpmyadmin web using :
	name : nhkr3131_root
	password : h9H7e1wbbgcP23
	privileges : all privileges

## HOW TO ADD NEW GAMES ##
1. table apps -> id in every games, like 12 for TTS, and 13 for find words,
2. if you develop new game, so you create new id for the apps.

## HOW TO ADD EVENTS ##
Description : this is table for how long the event in each apps will be running.
Example : in TTS/Find Words games, i want to limit the games only in few days, so the user cannot play the game after the limit time.

## TABLE QUEST ##
Description : this is table for save the question in each apps

## HOW TO GENERATE NEW QUESTION FOR TTS/FIND WORDS ##
1. go to  cpanel tts/find words:
	tts : http://localhost/nhkbp-pdgede/tts/cpanel/
	find words : http://localhost/nhkbp-pdgede/cari-kata/cpanel
	username : laurence
	passwords : 123456

2. insert new events manually in phpMyAdmin table events,

3. after login cpanel, go to Create New Item Menu,

4. insert INPUT EVENTS ID with event id in table event that you created,

5. insert new question from grid:
	Rule of this game, if you want to save in db, you must create minimum 10 question in each event !!
	This application support leveling game, so you can add 10 or more content for your leveling game.
	So, 1 event can have 1 or more content (> 10 content/level) -> 1 content can have 10 or more question!!
	Or, you can just edit table content, update events_id with events you already created, just please note the apps_id with content you want it.

	grid play : answer key for your tts/find words, if you want to cancel you can delete the column and replace using '#', then the column will be black again
	grid number : number for each question, if you want to cancel you can delete the column and replace using '#', then the column will be black again
	pertanyaan : question for each answer (vertical-menurun/horizontal-mendatar), don't forget to click add button after you insert the question.

6. after you finish create the question and the answer, click the submit button.

7. if you want to edit or delete the question you created, just go to the list of item in menu, then click the edit/delete button.

## RULE OF THE GAME ##
1. User only can play once each 12 hours, she/he can play again after 12 hours.
2. If user have 6 or more wrong answer, she/he will game over or can't continue the game.
3. User will finish the game if she/he completed all level, without have 6 or more wrong answer.
4. If you want to reset the user u must update table users_score, column created_at, just minus 12 hours from the last time created_at