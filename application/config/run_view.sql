/**
 * create logal Government view with state and country name
 */
CREATE
    ALGORITHM = MERGE
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `bf_lga_view` AS
    SELECT
        `bf_local_government`.`id` AS `id`,
        `bf_local_government`.`lga_name` AS `lga_name`,
        `bf_local_government`.`literacy` AS `literacy`,
        `bf_states`.`state_name` AS `state`,
        `bf_countries`.`printable_name` AS `country`,
        `bf_local_government`.`deleted` AS `deleted`
    FROM
        ((`bf_local_government`
        JOIN `bf_states` ON ((`bf_states`.`id` = `bf_local_government`.`state_id`)))
        JOIN `bf_countries` ON ((`bf_countries`.`iso` = `bf_states`.`country_code`)));

/**
 * Create user contact view with lga, state and country name;
 * this includes the user name
 */
CREATE
    ALGORITHM = MERGE
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `bf_contacts_view` AS
    SELECT
        `bf_contact_address`.`id` AS `id`,
        `bf_contact_address`.`user_id` AS `user_id`,
        `bf_users`.`firstname` AS `firstname`,
        `bf_users`.`middlename` AS `middlename`,
        `bf_users`.`lastname` AS `lastname`,
        CONCAT(`bf_users`.`firstname`,
                SPACE(1),
                `bf_users`.`middlename`,
                SPACE(1),
                `bf_users`.`lastname`) AS `fullname`,
        `bf_contact_address`.`street_line1` AS `street_line1`,
        `bf_contact_address`.`street_line2` AS `street_line2`,
        `bf_states`.`state_name` AS `state`,
        `bf_countries`.`printable_name` AS `country`,
        `bf_local_government`.`lga_name` AS `lga`,
        `bf_contact_address`.`postcode` AS `postcode`,
        `bf_contact_address`.`other` AS `other`,
        `bf_contact_address`.`telephone` AS `telephone`,
        `bf_contact_address`.`contact_type` AS `contact_type`
    FROM
        ((((`bf_contact_address`
        JOIN `bf_users` ON ((`bf_users`.`id` = `bf_contact_address`.`user_id`)))
        JOIN `bf_states` ON ((`bf_states`.`id` = `bf_contact_address`.`state_id`)))
        JOIN `bf_countries` ON ((`bf_countries`.`iso` = `bf_states`.`country_code`)))
        JOIN `bf_local_government` ON ((`bf_local_government`.`id` = `bf_contact_address`.`lga_id`)));

/**
 * Create students view to help student manager with all digits for their real name
 */
DROP TABLE IF EXISTS `bf_studentview`;

CREATE
    ALGORITHM = MERGE
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `bf_studentview` AS
    SELECT
        `s`.`id` AS `student_id`,
        `s`.`user_id` AS `user_id`,
        `s`.`matricNo` AS `matricNo`,
        `s`.`jamb_reg` AS `jamb_reg`,
        `s`.`progLevel` AS `level`,
        `s`.`studyMode` AS `studyMode`,
        `s`.`entryMode` AS `entryMode`,
        `s`.`status` AS `status`,
        `u`.`firstname` AS `firstname`,
        `u`.`middlename` AS `middlename`,
        `u`.`lastname` AS `lastname`,
        `p`.`id` AS `prog_id`,
        CONCAT(
            `dg`.`deg_Abbreviation`,
            convert(space(1) using utf8),
            `c`.`course_name`) AS `programme`,
        `p`.`duration` AS `duration`,
        `p`.`deg_id` AS `deg_id`,
        `c`.`course_name` AS `course`,
        `d`.`id` AS `dept_id`,
        `d`.`dept_name` AS `department`,
        `f`.`id` AS `fac_id`,
        `f`.`fac_name` AS `faculty`,
        `s`.`deleted` AS `deleted`
    FROM ((((((`bf_students` `s`
    JOIN `bf_users` `u` on((`u`.`id` = `s`.`user_id`)))
    JOIN `bf_program` `p` on((`p`.`id` = `s`.`prog_id`)))
    JOIN `bf_degree` `dg` on((`dg`.`id` = `p`.`deg_id`)))
    JOIN `bf_coursebank` `c` on((`c`.`id` = `p`.`course_id`)))
    JOIN `bf_department` `d` on((`d`.`id` = `c`.`dept_id`)))
    JOIN `bf_faculty` `f` on((`f`.`id` = `d`.`fac_id`)));
