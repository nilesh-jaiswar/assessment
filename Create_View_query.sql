CREATE VIEW CSS_Routes AS
SELECT ar.`sapid`, ar.`hostname`, ar.`loopback`, ar.`mac_address` FROM `assignment`.`route_details` ar
WHERE ar.`status` = 1
AND ar.`type` = 'CSS';