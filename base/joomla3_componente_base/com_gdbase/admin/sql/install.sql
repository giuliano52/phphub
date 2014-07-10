--
-- Struttura della tabella `#__gdbase_lnk_quiz_category`
--

CREATE TABLE IF NOT EXISTS `#__gdbase_lnk_quiz_category` (
  `id_lnk_quiz_category` int(11) NOT NULL AUTO_INCREMENT,
  `id_quiz` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id_lnk_quiz_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `#__gdbase_lnk_quiz_question`
--

CREATE TABLE IF NOT EXISTS `#__gdbase_lnk_quiz_question` (
  `id_lnk_quiz_question` int(11) NOT NULL AUTO_INCREMENT,
  `id_question` int(11) NOT NULL,
  `id_quiz` int(11) NOT NULL,
  PRIMARY KEY (`id_lnk_quiz_question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `#__gdbase_question`
--

CREATE TABLE IF NOT EXISTS `#__gdbase_question` (
  `id_question` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `correct_answer` text NOT NULL,
  `wrong_answer` text NOT NULL,
  `difficult_level` smallint(6) NOT NULL,
  `response_type` varchar(64) NOT NULL,
  `tags` varchar(255) NOT NULL,
  PRIMARY KEY (`id_question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `#__gdbase_quiz_categories`
--

CREATE TABLE IF NOT EXISTS `#__gdbase_quiz_categories` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent_catecogry` int(11) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `#__gdbase_quiz_name`
--

CREATE TABLE IF NOT EXISTS `#__gdbase_quiz_name` (
  `id_quiz` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `num_options` smallint(6) NOT NULL,
  `num_question_per_page` smallint(6) NOT NULL,
  `max_question_total` smallint(6) NOT NULL,
  `min_diffucult_level` tinyint(4) NOT NULL,
  `max_diffucult_level` tinyint(4) NOT NULL,
  `default_response_type` varchar(64) NOT NULL,
  `randomize_question` tinyint(1) NOT NULL,
  `reverse_question` tinyint(1) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `congratulation_file` varchar(255) NOT NULL,
  PRIMARY KEY (`id_quiz`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


