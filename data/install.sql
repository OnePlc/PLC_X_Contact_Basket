--
-- Add new tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('contact-basket', 'contact-single', 'Basket', 'Recent Basket', 'fas fa-basket', '', '1', '', '');

--
-- Add new partial
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Basket', 'contact_basket', 'contact-basket', 'contact-single', 'col-md-12', '', '', '0', '1', '0', '', '', '');

--
-- create basket table
--
CREATE TABLE `contact_basket` (
  `Basket_ID` int(11) NOT NULL,
  `contact_idfs` int(11) NOT NULL,
  `comment` TEXT NOT NULL DEFAULT '',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `contact_basket`
  ADD PRIMARY KEY (`Basket_ID`);

ALTER TABLE `contact_basket`
  MODIFY `Basket_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- add basket form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('contactbasket-single', 'Contact Basket', 'OnePlace\\Contact\\Basket\\Model\\Basket', 'OnePlace\\Contact\\Basket\\Model\\BasketTable');

--
-- add form tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('basket-base', 'contactbasket-single', 'Basket', 'Recent Basket', 'fas fa-basket', '', '1', '', '');

--
-- add address fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Comment', 'comment', 'basket-base', 'contactbasket-single', 'col-md-6', '', '', '0', '1', '0', '', '', ''),
(NULL, 'hidden', 'Basket', 'contact_idfs', 'basket-base', 'contactbasket-single', 'col-md-3', '', '/', '0', '1', '0', '', '', '');
