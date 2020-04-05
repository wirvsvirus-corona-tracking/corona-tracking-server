/***********************************
 * Delete all the outdated records *
 ***********************************/

DELETE FROM contact WHERE last_contact < (NOW() - INTERVAL 14 DAY);
