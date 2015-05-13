DELIMITER $$
--
-- Procedures
--

CREATE PROCEDURE `query_add_addedby_to_recipe`( IN `iadd` TEXT, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET addedby = inadd WHERE id = iid$$

CREATE PROCEDURE `query_add_added_to_recipe`( IN `stuff` DATE, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET added = stuff WHERE id = iid$$

CREATE PROCEDURE `query_add_admin_recipe_comments`( IN `rid` BIGINT, IN `uid` BIGINT, IN `comm` TEXT, IN `dt` DATE )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO comments( recipe, owner,
comment , date, checked )
VALUES (
rid, uid, comm, dt,
TRUE
)$$

CREATE PROCEDURE `query_add_aisle`( IN `aname` TEXT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO aisles( aisle )
VALUES (
aname
)$$

CREATE PROCEDURE `query_add_aisle_ing`( IN `ingid` BIGINT, IN `aid` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO ingredient_owner( ingredient, aisle, owner )
VALUES (
ingid, aid, uid
)$$

CREATE PROCEDURE `query_add_aisle_to_ing`( IN `aid` BIGINT, IN `ingid` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE ingredient_owner SET aisle = aid,
aisle_order = ( SELECT aisle_order
FROM (

SELECT DISTINCT aisle_order
FROM ingredient_owner
) AS x
WHERE aisle = aid
AND owner = uid )
WHERE ingredient = ingid
AND owner = uid$$

CREATE PROCEDURE `query_add_category`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO category( category )
VALUES (
name
)$$

CREATE PROCEDURE `query_add_cooktime_to_recipe`( IN `ctime` TEXT, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET cooktime = ctime WHERE id = iid$$

CREATE PROCEDURE `query_add_cuisine`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO cuisine( cuisine )
VALUES (
name
)$$

CREATE PROCEDURE `query_add_cuisine_to_recipe`( IN `cid` BIGINT, IN `rid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET cuisine = cid WHERE id = rid$$

CREATE PROCEDURE `query_add_date_pref`( IN `df` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE owner SET datefmt = df WHERE id = uid$$

CREATE PROCEDURE `query_add_diet`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO diet( diet )
VALUES (
name
)$$

CREATE PROCEDURE `query_add_directions_to_recipe`( IN `dir` TEXT, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET directions = dir WHERE id = iid$$

CREATE PROCEDURE `query_add_eboption_prefs`( IN `stoc` BOOLEAN, IN `scatt` BOOLEAN, IN `swelcome` BOOLEAN, IN `spdf` BOOLEAN, IN `srapp` BOOLEAN, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE owner SET toc = stoc,
catt = scatt,
welcome = swelcome,
pdf = spdf,
rapp = srapp WHERE id = uid$$

CREATE PROCEDURE `query_add_ebtitle_pref`( IN `title` TEXT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE owner SET ebtitle = title WHERE id = uid$$

CREATE PROCEDURE `query_add_exclusion`( IN `iid` INT, IN `uid` INT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO excluded_ing( ing, owner )
VALUES (
iid, uid
)$$

CREATE PROCEDURE `query_add_expiry`( IN `edate` TEXT )
    NO SQL
UPDATE server SET expire = edate$$

CREATE PROCEDURE `query_add_fav`( IN `iid` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO favourites( id, owner )
VALUES (
iid, uid
)$$

CREATE PROCEDURE `query_add_image`( IN `iname` TEXT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO image( image )
VALUES (
iname
)$$

CREATE PROCEDURE `query_add_image_to_recipe`( IN `iname` TEXT, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO recipe_image( recipe, image )
VALUES (
iid, get_image_id(
iname
)
)$$

CREATE PROCEDURE `query_add_ingredient`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO ingredient( ingredient )
VALUES (
name
)$$

CREATE PROCEDURE `query_add_list`( IN `uid` BIGINT, IN `lname` TEXT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO shopping_list( owner, list )
VALUES (
uid, lname
)$$

CREATE PROCEDURE `query_add_list_entry`( IN `lid` BIGINT, IN `ename` TEXT, IN `iid` BIGINT, IN `rid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO shopping_list_entry( list, entry, ing, recipe )
VALUES (
lid, ename, iid, rid
)$$

CREATE PROCEDURE `query_add_logdate_to_owner`( IN `date` DATE, IN `user` TEXT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
BEGIN 
UPDATE owner SET lastlogin = date WHERE owner = user$$
END$$

CREATE PROCEDURE `query_add_measure`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO measure( measure )
VALUES (
name
)$$

CREATE PROCEDURE `query_add_measure_pref`( IN `mid` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE owner SET measure = mid WHERE id = uid$$

CREATE PROCEDURE `query_add_measure_to_recipe`( IN `mid` BIGINT, IN `rid` INT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET measure = mid WHERE id = rid$$

CREATE PROCEDURE `query_add_menu`( IN `uid` BIGINT, IN `mname` TEXT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO menu( owner, menu )
VALUES (
uid, mname
)$$

CREATE PROCEDURE `query_add_menu_recipe`( IN `mid` BIGINT, IN `lval` TEXT, IN `rid` BIGINT, IN `dval` INT, IN `rval` INT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO menu_recipe( menu, link, recipe,
DAY , rank )
VALUES (
mid, lval, rid, dval, rval
)$$

CREATE PROCEDURE `query_add_note_to_recipe`( IN `stuff` TEXT, IN `iid` INT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET note = stuff WHERE id = iid$$

CREATE PROCEDURE `query_add_owner_category`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO category_owner( category, owner )
VALUES (
did, uid
)$$

CREATE PROCEDURE `query_add_owner_cuisine`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO cuisine_owner( cuisine, owner )
VALUES (
did, uid
)$$

CREATE PROCEDURE `query_add_owner_diet`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO diet_owner( diet, owner )
VALUES (
did, uid
)$$

CREATE PROCEDURE `query_add_owner_ingredient`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO ingredient_owner( ingredient, owner )
VALUES (
did, uid
)$$

CREATE PROCEDURE `query_add_owner_measure`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO measure_owner( measure, owner )
VALUES (
did, uid
)$$

CREATE PROCEDURE `query_add_owner_preprep`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO preprep_owner( preprep, owner )
VALUES (
did, uid
)$$

CREATE PROCEDURE `query_add_owner_sl_ingredient`( IN `iid` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO ingredient_owner( ingredient, owner, sl )
VALUES (
iid, uid,
TRUE
)$$

CREATE PROCEDURE `query_add_owner_source`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO source_owner( source, owner )
VALUES (
did, uid
)$$

CREATE PROCEDURE `query_add_owner_subcategory`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO subcategory_owner( subcategory, owner )
VALUES (
did, uid
)$$

CREATE PROCEDURE `query_add_owner_unit`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO unit_owner( unit, owner )
VALUES (
did, uid
)$$

CREATE PROCEDURE `query_add_owner_yield_unit`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO yield_unit_owner( yield_unit, owner )
VALUES (
did, uid
)$$

CREATE PROCEDURE `query_add_paper_pref`( IN `ps` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE owner SET paper = ps WHERE id = uid$$

CREATE PROCEDURE `query_add_pdf_to_recipe`( IN `pname` TEXT, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET pdf = pname WHERE id = iid$$

CREATE PROCEDURE `query_add_preprep`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO preprep( preprep )
VALUES (
name
)$$

CREATE PROCEDURE `query_add_preprep1_to_ing`( IN `pp` BIGINT, IN `iid` BIGINT, IN `ingid` BIGINT, IN `riid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe_ing SET preprep1 = pp WHERE recipe = iid AND ing = ingid AND id = riid$$

CREATE PROCEDURE `query_add_preprep2_to_ing`( IN `pp` BIGINT, IN `iid` BIGINT, IN `ingid` BIGINT, IN `riid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe_ing SET preprep2 = pp WHERE recipe = iid AND ing = ingid AND id = riid$$

CREATE PROCEDURE `query_add_preptime_to_recipe`( IN `ptime` TEXT, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET preptime = ptime WHERE id = iid$$

CREATE PROCEDURE `query_add_qtydec_to_ing`( IN `q` DECIMAL( 10, 3 ) , IN `iid` BIGINT, IN `ingid` BIGINT, IN `riid` INT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe_ing SET qtydec = q WHERE recipe = iid AND ing = ingid AND id = riid$$

CREATE PROCEDURE `query_add_quantity2_to_ing`( IN `q` TEXT, IN `iid` BIGINT, IN `ingid` BIGINT, IN `riid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe_ing SET quantity2 = q WHERE recipe = iid AND ing = ingid AND id = riid$$

CREATE PROCEDURE `query_add_quantity_to_ing`( IN `q` TEXT, IN `iid` BIGINT, IN `ingid` BIGINT, IN `riid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe_ing SET quantity = q WHERE recipe = iid AND ing = ingid AND id = riid$$

CREATE PROCEDURE `query_add_rating`( IN `rid` BIGINT, IN `rt` BIGINT, IN `rtid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO recipe_rating( recipe, rating, rater )
VALUES (
rid, rt, rtid
)$$

CREATE PROCEDURE `query_add_rating_to_recipe`( IN `rt` INT, IN `rts` INT, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET rating = rt,
total_ratings = rts WHERE id = iid$$

CREATE PROCEDURE `query_add_recipe`( IN `uid` BIGINT, IN `iname` TEXT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO recipe( owner, name )
VALUES (
uid, iname
)$$

CREATE PROCEDURE `query_add_recipe_cat`( IN `iid` BIGINT, IN `catid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO recipe_cat_subcat( recipe, cat )
VALUES (
iid, catid
)$$

CREATE PROCEDURE `query_add_recipe_cat_subcat`( IN `iid` BIGINT, IN `catid` BIGINT, IN `subcatid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO recipe_cat_subcat( recipe, cat, subcat )
VALUES (
iid, catid, subcatid
)$$

CREATE PROCEDURE `query_add_recipe_comments`( IN `rid` BIGINT, IN `uid` BIGINT, IN `comm` TEXT, IN `dt` DATE )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO comments( recipe, owner,
comment , date )
VALUES (
rid, uid, comm, dt
)$$

CREATE PROCEDURE `query_add_recipe_diet`( IN `iid` BIGINT, IN `rid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO recipe_diet( recipe, diet )
VALUES (
iid, rid
)$$

CREATE PROCEDURE `query_add_recipe_ing`( IN `iid` BIGINT, IN `ingid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO recipe_ing( recipe, ing )
VALUES (
iid, ingid
)$$

CREATE PROCEDURE `query_add_related_recipe`( IN `iid` BIGINT, IN `rid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
INSERT INTO recipe_recipe( id, related_id )
VALUES (
iid, rid
)$$

CREATE PROCEDURE `query_add_source`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO source( source )
VALUES (name)$$

CREATE PROCEDURE `query_add_source_to_recipe`( IN `sid` BIGINT, IN `rid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET source = sid WHERE id = rid$$

CREATE PROCEDURE `query_add_subcategory`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO subcategory( subcategory )
VALUES (
name
)$$

CREATE PROCEDURE `query_add_tried_to_recipe`( IN `tvalue` BOOLEAN, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET tried = tvalue WHERE id = iid$$

CREATE PROCEDURE `query_add_unit`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO unit( unit )
VALUES (
name
)$$

CREATE PROCEDURE `query_add_unit2_to_ing`( IN `u` BIGINT, IN `iid` BIGINT, IN `ingid` BIGINT, IN `riid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe_ing SET unit2 = u WHERE recipe = iid AND ing = ingid AND id = riid$$

CREATE PROCEDURE `query_add_unit_to_ing`( IN `u` BIGINT, IN `iid` BIGINT, IN `ingid` BIGINT, IN `riid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe_ing SET unit = u WHERE recipe = iid AND ing = ingid AND id = riid$$

CREATE PROCEDURE `query_add_updated_to_recipe`( IN `udate` DATE, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET updated = udate WHERE id = iid$$

CREATE PROCEDURE `query_add_video_to_recipe`( IN `vname` TEXT, IN `rid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET video = vname WHERE id = rid$$

CREATE PROCEDURE `query_add_visible_to_recipe`( IN `vis` BOOLEAN, IN `oid` BIGINT, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET visible = vis,
owner = oid WHERE id = iid$$

CREATE PROCEDURE `query_add_yield_to_recipe`( IN `stuff` INT, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET yield = stuff WHERE id = iid$$

CREATE PROCEDURE `query_add_yield_unit`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
INSERT INTO yield_unit( yield_unit )
VALUES (
name
)$$

CREATE PROCEDURE `query_add_yield_unit_to_recipe`( IN `yid` BIGINT, IN `rid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET yield_unit = yid WHERE id = rid$$

CREATE PROCEDURE `query_aisle_exists`( IN `aname` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM aisles
WHERE BINARY aisle = aname$$

CREATE PROCEDURE `query_aisle_has_order`( IN `aid` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT DISTINCT aisle_order
FROM ingredient_owner
WHERE aisle = aid
AND owner = uid$$

CREATE PROCEDURE `query_aisle_id`( IN `aname` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM aisles
WHERE BINARY aisle = aname$$

CREATE PROCEDURE `query_aisle_used_by_others`( IN `aid` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM ingredient_owner
WHERE aisle = aid
AND owner != uid$$

CREATE PROCEDURE `query_all_categorys`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT category, id
FROM category
WHERE id !=20
ORDER BY category$$

CREATE PROCEDURE `query_all_ingredients`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT ingredient, id
FROM ingredient
WHERE id
IN (

SELECT ingredient
FROM ingredient_owner
WHERE owner = uid
)
ORDER BY ingredient$$

CREATE PROCEDURE `query_all_pp`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT preprep, id
FROM preprep
WHERE id
IN (

SELECT preprep
FROM preprep_owner
WHERE owner = uid
)
ORDER BY preprep$$

CREATE PROCEDURE `query_all_subcategorys`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT subcategory, id
FROM subcategory
WHERE id !=32
ORDER BY subcategory$$

CREATE PROCEDURE `query_all_units`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT unit, id
FROM unit
WHERE id
IN (

SELECT unit
FROM unit_owner
WHERE owner = uid
)
ORDER BY unit$$

CREATE PROCEDURE `query_all_yield_units`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT yield_unit, id
FROM yield_unit
WHERE id
IN (

SELECT yield_unit
FROM yield_unit_owner
WHERE owner = uid
)
ORDER BY yield_unit$$

CREATE PROCEDURE `query_approve`( IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET approved = TRUE WHERE id = iid$$

CREATE PROCEDURE `query_approve_user`( IN `uname` TEXT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE owner SET approved = TRUE WHERE BINARY owner = uname$$

CREATE PROCEDURE `query_category_exists`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM category
WHERE BINARY category = name$$

CREATE PROCEDURE `query_category_or_categorys_exists`( IN `cname` TEXT, IN `cnames` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM category
WHERE upper( category ) = upper( cname )
OR upper( category ) = upper( cnames )$$

CREATE PROCEDURE `query_category_owner_exists`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM category_owner
WHERE category = did
AND owner = uid$$

CREATE PROCEDURE `query_cats`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT category
FROM category
WHERE id !=20
ORDER BY category$$

CREATE PROCEDURE `query_cat_name`( IN `cid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT category
FROM category
WHERE id = cid$$

CREATE PROCEDURE `query_check_if_fav`( IN `iid` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM favourites
WHERE id = iid
AND owner = uid$$

CREATE PROCEDURE `query_chk_image_used_elsewhere`( IN `imageid` BIGINT, IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT image
FROM recipe_image
WHERE image = imageid
AND NOT recipe = iid$$

CREATE PROCEDURE `query_chk_ing_used_elsewhere`( IN `iid` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM ingredient_owner
WHERE ingredient = iid
AND owner != uid$$

CREATE PROCEDURE `query_chk_pdf_used_elsewhere`( IN `pdfname` TEXT, IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM recipe
WHERE BINARY pdf = pdfname
AND NOT id = iid$$

CREATE PROCEDURE `query_chk_pp_used_elsewhere`( IN `iid` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM preprep_owner
WHERE preprep = iid
AND owner != uid$$

CREATE PROCEDURE `query_chk_unit_used_elsewhere`( IN `iid` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM unit_owner
WHERE unit = iid
AND owner != uid$$

CREATE PROCEDURE `query_chk_video_used_elsewhere`( IN `videoname` TEXT, IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM recipe
WHERE BINARY video = videoname
AND NOT id = iid$$

CREATE PROCEDURE `query_chk_yield_unit_used_elsewhere`( IN `yid` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM yield_unit_owner
WHERE yield_unit = yid
AND owner != uid$$

CREATE PROCEDURE `query_clear_recipe_combos`( IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
BEGIN DELETE FROM recipe_diet WHERE recipe = iid$$

DELETE FROM recipe_recipe WHERE id = iid$$

DELETE FROM recipe_cat_subcat WHERE recipe = iid$$

DELETE FROM recipe_ing WHERE recipe = iid$$

END$$

CREATE PROCEDURE `query_comments`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT commentid,
comment , date, get_owner(
owner
) AS owner, get_recipename(
recipe
) AS recipename
FROM comments
WHERE checked IS NOT
TRUE ORDER BY date DESC$$

CREATE PROCEDURE `query_comment_checked`( IN `cid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE comments SET checked = TRUE WHERE commentid = cid$$

CREATE PROCEDURE `query_cuisines`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT cuisine, id
FROM cuisine
WHERE id
IN (

SELECT DISTINCT cuisine
FROM recipe
)
ORDER BY cuisine$$

CREATE PROCEDURE `query_cuisine_exists`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM cuisine
WHERE BINARY cuisine = name$$

CREATE PROCEDURE `query_cuisine_or_cuisines_exists`( IN `cname` TEXT, IN `cnames` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM cuisine
WHERE upper( cuisine ) = upper( cname )
OR upper( cuisine ) = upper( cnames )$$

CREATE PROCEDURE `query_cuisine_owner_exists`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM cuisine_owner
WHERE cuisine = did
AND owner = uid$$

CREATE PROCEDURE `query_delete_aisle`( IN `aname` TEXT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM aisles WHERE BINARY aisle = aname$$

CREATE PROCEDURE `query_delete_cat`( IN `cid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM category WHERE id = cid$$

CREATE PROCEDURE `query_delete_comment`( IN `cid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM comments WHERE commentid = cid$$

CREATE PROCEDURE `query_delete_exclusions`( IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM excluded_ing WHERE owner = uid$$

CREATE PROCEDURE `query_delete_fav`( IN `iid` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
DELETE FROM favourites WHERE id = iid AND owner = uid$$

CREATE PROCEDURE `query_delete_image`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
DELETE FROM image WHERE id = iid$$

CREATE PROCEDURE `query_delete_ing`( IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM ingredient WHERE id = iid$$

CREATE PROCEDURE `query_delete_list`( IN `lid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM shopping_list WHERE id = lid$$

CREATE PROCEDURE `query_delete_menu`( IN `mid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM menu WHERE id = mid$$

CREATE PROCEDURE `query_delete_owner_ing`( IN `iid` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM ingredient_owner WHERE ingredient = iid AND owner = uid$$

CREATE PROCEDURE `query_delete_owner_pp`( IN `iid` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM preprep_owner WHERE preprep = iid AND owner = uid$$

CREATE PROCEDURE `query_delete_owner_unit`( IN `iid` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM unit_owner WHERE unit = iid AND owner = uid$$

CREATE PROCEDURE `query_delete_owner_yield_unit`( IN `yid` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM yield_unit_owner WHERE yield_unit = yid AND owner = uid$$

CREATE PROCEDURE `query_delete_pp`( IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM preprep WHERE id = iid$$

CREATE PROCEDURE `query_delete_recipe`( IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM recipe WHERE id = iid$$

CREATE PROCEDURE `query_delete_recipe_comments`( IN `rid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM comments WHERE recipe = rid$$

CREATE PROCEDURE `query_delete_recipe_image`(IN `rid` BIGINT, IN `iid` BIGINT) NOT DETERMINISTIC MODIFIES SQL DATA SQL SECURITY INVOKER DELETE FROM recipe_image WHERE recipe = rid AND image = iid$$

CREATE PROCEDURE `query_delete_recipe_images`( IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM recipe_image WHERE recipe = iid$$

CREATE PROCEDURE `query_delete_recipe_pdf`( IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET pdf = NULL WHERE id = iid$$

CREATE PROCEDURE `query_delete_recipe_video`( IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET video = NULL WHERE id = iid$$

CREATE PROCEDURE `query_delete_subcat`( IN `cid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM subcategory WHERE id = cid$$

CREATE PROCEDURE `query_delete_unit`( IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM unit WHERE id = iid$$

CREATE PROCEDURE `query_delete_user`( IN `uname` TEXT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM owner WHERE BINARY owner = uname$$

CREATE PROCEDURE `query_delete_yield_unit`( IN `yid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM yield_unit WHERE id = yid$$

CREATE PROCEDURE `query_del_rating`( IN `iid` BIGINT, IN `rid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
DELETE FROM recipe_rating WHERE recipe = iid AND rater = rid$$

CREATE PROCEDURE `query_diets`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT diet, id
FROM diet
WHERE id
IN (

SELECT DISTINCT diet
FROM recipe_diet
WHERE recipe
IN (

SELECT DISTINCT id
FROM recipe
)
)
ORDER BY diet$$

CREATE PROCEDURE `query_diet_exists`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM diet
WHERE BINARY diet = name$$

CREATE PROCEDURE `query_diet_or_diets_exists`( IN `dname` TEXT, IN `dnames` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM diet
WHERE upper( diet ) = upper( dname )
OR upper( diet ) = upper( dnames )$$

CREATE PROCEDURE `query_diet_owner_exists`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM diet_owner
WHERE diet = did
AND owner = uid$$

CREATE PROCEDURE `query_email_in_use`( IN `newemail` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT email
FROM owner
WHERE email = newemail$$

CREATE PROCEDURE `query_email_user`( IN `user` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT email
FROM owner
WHERE owner = user$$

CREATE PROCEDURE `query_expiry`( )
    NO SQL
SELECT DISTINCT expire
FROM server$$

CREATE PROCEDURE `query_hide_recipe`( IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET visible = FALSE WHERE id = iid$$

CREATE PROCEDURE `query_image_exists`( IN `iname` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM image
WHERE BINARY image = iname$$

CREATE PROCEDURE `query_ingredient_exists`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM ingredient
WHERE BINARY ingredient = name$$

CREATE PROCEDURE `query_ingredient_name`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT ingredient
FROM ingredient
WHERE id = iid$$

CREATE PROCEDURE `query_ingredient_owner_exists`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM ingredient_owner
WHERE ingredient = did
AND owner = uid$$

CREATE PROCEDURE `query_latest_recipe`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, greatest( added, updated ) AS date
FROM recipe
WHERE visible IS
TRUE AND approved IS
TRUE ORDER BY date DESC
LIMIT 1$$

CREATE PROCEDURE `query_latest_recipe_ing`( IN `iid` BIGINT, IN `ingid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
SELECT max( id ) AS id
FROM recipe_ing
WHERE recipe = iid
AND ing = ingid
ORDER BY id DESC
LIMIT 1$$

CREATE PROCEDURE `query_latest_unapproved`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, greatest( added, updated ) AS date
FROM recipe
WHERE approved IS NOT
TRUE ORDER BY date DESC
LIMIT 1$$

CREATE PROCEDURE `query_list`(IN `lid` BIGINT, IN `uid` BIGINT) NOT DETERMINISTIC READS SQL DATA SQL SECURITY INVOKER SELECT entry, get_ingredient( ing ) AS ing, get_ing_aisle( ing, uid ) AS aisle, recipe, get_ing_aisle_order( ing, uid ) AS aisle_order, (SELECT aisle IS null FROM ingredient_owner WHERE ingredient=ing and owner=uid) as anull, get_ing_aisle_order(ing,uid) IS NULL as aonull FROM shopping_list_entry WHERE list = lid ORDER BY aonull, aisle_order, anull, aisle, ing$$$$

CREATE PROCEDURE `query_measures`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, measure
FROM measure
ORDER BY measure$$

CREATE PROCEDURE `query_measure_exists`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM measure
WHERE BINARY measure = name$$

CREATE PROCEDURE `query_measure_owner_exists`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM measure_owner
WHERE measure = did
AND owner = uid$$

CREATE PROCEDURE `query_menu`( IN `mid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT link, recipe,
day , rank
FROM menu_recipe
WHERE menu = mid
ORDER BY day , rank$$

CREATE PROCEDURE `query_menu_exists`( IN `mname` TEXT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM menu
WHERE BINARY menu = mname
AND owner = uid$$

CREATE PROCEDURE `query_new_list_id`( IN `lname` TEXT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM shopping_list
WHERE BINARY list = lname
AND owner = uid$$

CREATE PROCEDURE `query_new_menu_id`( IN `mname` TEXT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM menu
WHERE BINARY menu = mname
AND owner = uid$$

CREATE PROCEDURE `query_new_recipe_id`( IN `rname` TEXT, IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT max( id )
FROM recipe
WHERE BINARY name = rname
AND owner = iid$$

CREATE PROCEDURE `query_owner`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT email, fname, lname
FROM owner
WHERE id = uid$$

CREATE PROCEDURE `query_owner_aisles`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT DISTINCT aisle AS id, get_aisle(
aisle
) AS aisle, aisle_order
FROM ingredient_owner
WHERE owner = uid
AND aisle IS NOT NULL
ORDER BY aisle_order, aisle$$

CREATE PROCEDURE `query_owner_aisle_list`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT DISTINCT aisle AS id, get_aisle(
aisle
) AS aisle
FROM ingredient_owner
WHERE owner = uid
AND aisle IS NOT NULL
ORDER BY aisle$$

CREATE PROCEDURE `query_owner_cuisines`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT get_cuisine(
cuisine
) AS cuisine, cuisine AS id
FROM cuisine_owner
WHERE owner = uid
ORDER BY cuisine$$

CREATE PROCEDURE `query_owner_diets`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT get_diet(
diet
) AS diet, diet AS id
FROM diet_owner
WHERE owner = uid
ORDER BY diet$$

CREATE PROCEDURE `query_owner_excl_ingredients`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT ing, get_ingredient(
ing
) AS ingredient
FROM excluded_ing
WHERE owner = uid
ORDER BY ingredient$$

CREATE PROCEDURE `query_owner_favourites`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, get_recipename(
id
) AS name
FROM favourites
WHERE owner = uid
ORDER BY name$$

CREATE PROCEDURE `query_owner_ids`( IN `user` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN SELECT id
FROM owner
WHERE owner = user$$
END$$

CREATE PROCEDURE `query_owner_ingredients`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT get_ingredient(
ingredient
) AS ingredient
FROM ingredient_owner
WHERE owner = uid
ORDER BY ingredient$$

CREATE PROCEDURE `query_owner_ingredients_ids`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, ingredient
FROM ingredient
WHERE id
IN (

SELECT DISTINCT ing
FROM recipe_ing
WHERE get_recipe_owner(
recipe
) = uid
)
ORDER BY ingredient$$

CREATE PROCEDURE `query_owner_is_admin`( IN `user` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM owner
WHERE owner = user
AND admin IS
TRUE$$

CREATE PROCEDURE `query_owner_lists`( IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
SELECT id, list
FROM shopping_list
WHERE owner = uid
ORDER BY list$$

CREATE PROCEDURE `query_owner_measures`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT get_measure(
measure
) AS measure
FROM measure_owner
WHERE owner = uid
ORDER BY measure$$

CREATE PROCEDURE `query_owner_menus`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, menu
FROM menu
WHERE owner = uid
ORDER BY menu$$

CREATE PROCEDURE `query_owner_menu_cats` ( ) NOT DETERMINISTIC READS SQL DATA SQL SECURITY INVOKER SELECT DISTINCT get_category(
cat
) AS category, cat
FROM recipe_cat_subcat
WHERE recipe
IN (

SELECT id
FROM recipe
WHERE visible IS NOT
FALSE
)
ORDER BY category$$

$$

CREATE PROCEDURE `query_owner_menu_recipes`( IN `catid` BIGINT, IN `scid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT DISTINCT get_recipename(
recipe
) AS recipename, recipe
FROM recipe_cat_subcat
WHERE cat = catid
AND subcat = scid
AND recipe
IN (

SELECT id
FROM recipe
WHERE visible IS
TRUE AND approved IS
TRUE
)
ORDER BY recipename$$

CREATE PROCEDURE `query_owner_menu_recipes_no_subcats`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT DISTINCT get_recipename(
recipe
) AS recipename, recipe
FROM recipe_cat_subcat
WHERE cat = iid
AND subcat IS NULL
AND recipe
IN (

SELECT id
FROM recipe
WHERE visible IS
TRUE AND approved IS
TRUE
)
ORDER BY recipename$$

CREATE PROCEDURE `query_owner_menu_subcats`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT DISTINCT get_subcategory(
subcat
) AS subcategory, subcat
FROM recipe_cat_subcat
WHERE cat = iid
AND subcat >0
AND recipe
IN (

SELECT id
FROM recipe
WHERE visible IS
TRUE AND approved IS
TRUE
)
ORDER BY subcategory$$

CREATE PROCEDURE `query_owner_nexcl_ingredients_ids_no_hdr`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, ingredient
FROM ingredient
WHERE id
IN (

SELECT DISTINCT ing
FROM recipe_ing
WHERE get_recipe_owner(
recipe
) = uid
)
AND id NOT
IN (

SELECT ing
FROM excluded_ing
WHERE owner = uid
)
AND BINARY upper( ingredient ) != ingredient
ORDER BY ingredient$$

CREATE PROCEDURE `query_owner_prefs`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT rapp
FROM owner
WHERE admin IS
TRUE AND rapp IS
TRUE$$

CREATE PROCEDURE `query_owner_prepreps`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT get_preprep(
preprep
) AS preprep
FROM preprep_owner
WHERE owner = uid
ORDER BY preprep$$

CREATE PROCEDURE `query_owner_recipes_with_name`( IN `rname` TEXT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM recipe
WHERE BINARY upper( name ) = upper( rname )
AND owner = uid$$

CREATE PROCEDURE `query_owner_slitems_ids_aisles`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, ingredient, get_ing_aisle(
id, uid
)
FROM ingredient
WHERE id
IN (

SELECT ingredient
FROM ingredient_owner
WHERE sl IS
TRUE AND owner = uid
)
ORDER BY ingredient$$

CREATE PROCEDURE `query_owner_sources`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT get_source(
source
) AS source
FROM source_owner
WHERE owner = uid
ORDER BY source$$

CREATE PROCEDURE `query_owner_units`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT get_unit(
unit
) AS unit
FROM unit_owner
WHERE owner = uid
ORDER BY unit$$

CREATE PROCEDURE `query_owner_yield_units`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT get_yield_unit(
yield_unit
) AS yield_unit
FROM yield_unit_owner
WHERE owner = uid
ORDER BY yield_unit$$

CREATE PROCEDURE `query_pp_name`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT preprep
FROM preprep
WHERE id = iid$$

CREATE PROCEDURE `query_preprep_exists`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM preprep
WHERE BINARY preprep = name$$

CREATE PROCEDURE `query_preprep_owner_exists`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM preprep_owner
WHERE preprep = did
AND owner = uid$$

CREATE PROCEDURE `query_rating`( IN `rid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT sum( rating ) AS total_rating, count( rater ) AS total_ratings
FROM recipe_rating
WHERE recipe = rid
GROUP BY recipe$$

CREATE PROCEDURE `query_recipe`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT name, directions, note, get_source(
source
) AS source, get_cuisine(
cuisine
) AS cuisine, rating, updated, yield, tried, preptime, get_yield_unit(
yield_unit
) AS yield_unit, get_measure(
measure
) AS measure, added, total_ratings, pdf, addedby, cooktime, video
FROM recipe
WHERE id = iid$$

CREATE PROCEDURE `query_recipes_with_name_id`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, name
FROM recipe
WHERE approved IS
TRUE AND visible IS
TRUE ORDER BY name$$

CREATE PROCEDURE `query_recipes_with_name_id_owner`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, name, get_owner(
owner
) AS owner
FROM recipe
ORDER BY name$$

CREATE PROCEDURE `query_recipes_with_name_id_owner_visible`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, name, get_owner(
owner
) AS owner, visible
FROM recipe
WHERE visible IS
FALSE ORDER BY name$$

CREATE PROCEDURE `query_recipe_cats`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT get_category(
cat
) AS category, get_subcategory(
subcat
) AS subcategory
FROM recipe_cat_subcat
WHERE recipe = iid$$

CREATE PROCEDURE `query_recipe_comments`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT commentid,
comment , date, get_owner(
owner
) AS owner
FROM comments
WHERE recipe = iid
ORDER BY date DESC$$

CREATE PROCEDURE `query_recipe_diets`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT get_diet(
diet
) AS diet
FROM recipe_diet
WHERE recipe = iid$$

CREATE PROCEDURE `query_recipe_images`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT image AS id, get_image(
image
) AS image
FROM recipe_image
WHERE recipe = iid$$

CREATE PROCEDURE `query_recipe_ings`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT quantity, get_unit(
unit
) AS unit, get_ingredient(
ing
) AS ingredient, get_preprep(
preprep1
) AS preprep1, get_preprep(
preprep2
) AS preprep2, quantity2, get_unit(
unit2
) AS unit2, qtydec
FROM recipe_ing
WHERE recipe = iid
ORDER BY id$$

CREATE PROCEDURE `query_recipe_ings_export`( IN `rid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT quantity, get_unit(
unit
) AS unit, quantity2, get_unit(
unit2
) AS unit2, get_ingredient(
ing
) AS ingredient, get_preprep(
preprep1
) AS preprep1, get_preprep(
preprep2
) AS preprep2
FROM recipe_ing
WHERE recipe = rid
ORDER BY id$$

CREATE PROCEDURE `query_recipe_name`( IN `rid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
SELECT name
FROM recipe
WHERE id = rid$$

CREATE PROCEDURE `query_recipe_names`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT DISTINCT name
FROM recipe
WHERE owner = iid
ORDER BY name$$

CREATE PROCEDURE `query_recipe_number`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, approved
FROM recipe
WHERE visible IS
TRUE$$

CREATE PROCEDURE `query_recipe_owner`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT owner
FROM recipe
WHERE id = iid$$

CREATE PROCEDURE `query_recipe_pdf`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT pdf
FROM recipe
WHERE id = iid
AND pdf IS NOT NULL$$

CREATE PROCEDURE `query_recipe_ratings`( IN `id` BIGINT, IN `rid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM recipe_rating
WHERE recipe = id
AND rater = rid$$

CREATE PROCEDURE `query_recipe_video`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT video
FROM recipe
WHERE id = iid
AND video IS NOT NULL$$

CREATE PROCEDURE `query_related_recipes`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, related_id, get_recipename(
id
) AS name, get_recipename(
related_id
) AS relname
FROM recipe_recipe
WHERE id = iid$$

CREATE PROCEDURE `query_remove_aisle_from_ing`( IN `aid` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE ingredient_owner SET aisle = NULL ,
aisle_order = NULL WHERE aisle = aid AND owner = uid$$

CREATE PROCEDURE `query_reset_user_pass`( IN `user` TEXT, IN `enpass` TEXT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE owner SET password = enpass WHERE owner = user$$

CREATE PROCEDURE `query_source_exists`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM source
WHERE BINARY source = name$$

CREATE PROCEDURE `query_source_owner_exists`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM source_owner
WHERE source = did
AND owner = uid$$

CREATE PROCEDURE `query_subcategory_exists`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM subcategory
WHERE BINARY subcategory = name$$

CREATE PROCEDURE `query_subcategory_or_subcategorys_exists`( IN `sname` TEXT, IN `snames` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM subcategory
WHERE upper( subcategory ) = upper( sname )
OR upper( subcategory ) = upper( snames )$$

CREATE PROCEDURE `query_subcategory_owner_exists`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM subcategory_owner
WHERE subcategory = did
AND owner = uid$$

CREATE PROCEDURE `query_subcats`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT subcategory
FROM subcategory
WHERE id !=32
ORDER BY subcategory$$

CREATE PROCEDURE `query_subcat_name`( IN `cid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT subcategory
FROM subcategory
WHERE id = cid$$

CREATE PROCEDURE `query_unapproved_menu_cats`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT DISTINCT get_category(
cat
) AS category, cat
FROM recipe_cat_subcat
WHERE recipe
IN (

SELECT id
FROM recipe
WHERE visible IS
TRUE AND approved IS NOT
TRUE
)
ORDER BY category$$

CREATE PROCEDURE `query_unapproved_menu_recipes`( IN `catid` BIGINT, IN `scid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT DISTINCT get_recipename(
recipe
) AS recipename, recipe
FROM recipe_cat_subcat
WHERE cat = catid
AND subcat = scid
AND recipe
IN (

SELECT id
FROM recipe
WHERE visible IS
TRUE AND approved IS NOT
TRUE
)
ORDER BY recipename$$

CREATE PROCEDURE `query_unapproved_menu_recipes_no_subcats`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT DISTINCT get_recipename(
recipe
) AS recipename, recipe
FROM recipe_cat_subcat
WHERE cat = iid
AND subcat IS NULL
AND recipe
IN (

SELECT id
FROM recipe
WHERE visible IS
TRUE AND approved IS NOT
TRUE
)
ORDER BY recipename$$

CREATE PROCEDURE `query_unapproved_menu_subcats`( IN `iid` INT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT DISTINCT get_subcategory(
subcat
) AS subcategory, subcat
FROM recipe_cat_subcat
WHERE cat = iid
AND subcat >0
AND recipe
IN (

SELECT id
FROM recipe
WHERE visible IS
TRUE AND approved IS NOT
TRUE
)
ORDER BY subcategory$$

CREATE PROCEDURE `query_unapproved_users`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT owner, fname, lname, email, regdate
FROM owner
WHERE approved IS NOT
TRUE ORDER BY owner$$

CREATE PROCEDURE `query_unapp_user_number`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM owner
WHERE approved IS NOT
TRUE$$

CREATE PROCEDURE `query_unit_exists`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM unit
WHERE BINARY unit = name$$

CREATE PROCEDURE `query_unit_name`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT unit
FROM unit
WHERE id = iid$$

CREATE PROCEDURE `query_unit_owner_exists`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM unit_owner
WHERE unit = did
AND owner = uid$$

CREATE PROCEDURE `query_updated_email_in_use`( IN `newemail` TEXT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT email
FROM owner
WHERE BINARY email = newemail
AND id != uid$$

CREATE PROCEDURE `query_update_aisle`( IN `naname` TEXT, IN `aname` TEXT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE aisles SET aisle = naname WHERE aisle = aname$$

CREATE PROCEDURE `query_update_owner_admin`( IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE owner SET admin = 1 WHERE id = uid$$

CREATE PROCEDURE `query_upd_aisle_for_ing`( IN `naid` BIGINT, IN `aid` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
UPDATE ingredient_owner SET aisle = naid WHERE aisle = aid AND owner = uid$$

CREATE PROCEDURE `query_upd_cat`( IN `cname` TEXT, IN `cid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE category SET category = cname WHERE id = cid$$

CREATE PROCEDURE `query_upd_categorys_in_recipes`( IN `ncid` BIGINT, IN `cid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe_cat_subcat SET cat = ncid WHERE cat = cid$$

CREATE PROCEDURE `query_upd_ing`( IN `iname` TEXT, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE ingredient SET ingredient = iname WHERE id = iid$$

CREATE PROCEDURE `query_upd_ings_in_recipes`( IN `ingid` BIGINT, IN `oid` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe_ing SET ing = ingid WHERE ing = oid AND recipe IN (
SELECT id
FROM recipe
WHERE owner = uid
)$$

CREATE PROCEDURE `query_upd_name_in_recipes`( IN `rname` TEXT, IN `rid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET name = rname WHERE id = rid$$

CREATE PROCEDURE `query_upd_owner`( IN `newfname` TEXT, IN `newemail` TEXT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
UPDATE owner SET fname = newfname,
email = newemail WHERE id = uid$$

CREATE PROCEDURE `query_upd_owner_admin`( IN `uname` TEXT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE owner SET admin =1 WHERE BINARY owner = uname$$

CREATE PROCEDURE `query_upd_owner_in_recipes`( IN `oid` BIGINT, IN `rid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET owner = oid WHERE id = rid$$

CREATE PROCEDURE `query_upd_owner_lname`( IN `newname` TEXT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE owner SET lname = newname WHERE id = uid$$

CREATE PROCEDURE `query_upd_owner_pass`( IN `pass` TEXT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE owner SET PASSWORD = pass WHERE id = uid$$

CREATE PROCEDURE `query_upd_pp` ( IN `pname` TEXT, IN `ppid` BIGINT ) NOT DETERMINISTIC MODIFIES SQL DATA SQL SECURITY INVOKER UPDATE preprep SET preprep = pname WHERE id = ppid$$

CREATE PROCEDURE `query_upd_pp_in_recipes`( IN `pid` BIGINT, IN `oid` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
BEGIN UPDATE recipe_ing SET preprep1 = pid WHERE preprep1 = oid AND recipe IN (
SELECT id
FROM recipe
WHERE owner = uid
)$$

UPDATE recipe_ing SET preprep2 = pid WHERE preprep2 = oid AND recipe IN (
SELECT id
FROM recipe
WHERE owner = uid
)$$

END$$

CREATE PROCEDURE `query_upd_rating`( IN `rt` SMALLINT, IN `rid` BIGINT, IN `id` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe_rating SET rating = rt WHERE rater = rid AND recipe = id$$

CREATE PROCEDURE `query_upd_recipe`( IN `iname` TEXT, IN `iid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET name = iname WHERE id = iid$$

CREATE PROCEDURE `query_upd_subcat`( IN `cname` TEXT, IN `cid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE subcategory SET subcategory = cname WHERE id = cid$$

CREATE PROCEDURE `query_upd_subcategorys_in_recipes`( IN `cid` BIGINT, IN `ocid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe_cat_subcat SET subcat = cid WHERE subcat = ocid$$

CREATE PROCEDURE `query_upd_unit`( IN `uname` TEXT, IN `unitid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE unit SET unit = uname WHERE id = unitid$$

CREATE PROCEDURE `query_upd_unit_in_recipes`( IN `unitid` BIGINT, IN `oid` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
BEGIN UPDATE recipe_ing SET unit = unitid WHERE unit = oid AND recipe IN (
SELECT id
FROM recipe
WHERE owner = uid
)$$

UPDATE recipe_ing SET unit2 = unitid WHERE unit2 = oid AND recipe IN (
SELECT id
FROM recipe
WHERE owner = uid
)$$

END$$

CREATE PROCEDURE `query_upd_user_admin`( )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE owner SET admin = FALSE$$

CREATE PROCEDURE `query_upd_yield_unit`( IN `yname` TEXT, IN `yid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE yield_unit SET yield_unit = yname WHERE id = yid$$

CREATE PROCEDURE `query_upd_yield_unit_in_recipes`( IN `yid` BIGINT, IN `oid` BIGINT, IN `uid` BIGINT )
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
UPDATE recipe SET yield_unit = yid WHERE yield_unit = oid AND owner = uid$$

CREATE PROCEDURE `query_user_email`( IN `email` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT owner
FROM owner
WHERE email = email$$

CREATE PROCEDURE `query_user_extra_details`( IN `uname` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT lastlogin, admin, id
FROM owner
WHERE BINARY owner = uname$$

CREATE PROCEDURE `query_user_number`( )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, owner
FROM owner
WHERE approved IS
TRUE$$

CREATE PROCEDURE `query_user_prefs`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT toc, catt, datefmt, measure, ebtitle, paper, get_measure(
measure
) AS msname, pdf, rapp
FROM owner
WHERE id = iid$$

CREATE PROCEDURE `query_user_recipes_with_name`( IN `rname` TEXT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM recipe
WHERE upper( name ) = upper( rname )
AND owner = uid$$

CREATE PROCEDURE `query_user_recipes_with_name_id`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id, name
FROM recipe
WHERE owner = uid
AND visible IS
TRUE AND approved IS
TRUE ORDER BY name$$

CREATE PROCEDURE `query_user_recipe_number`( IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM recipe
WHERE owner = uid
AND visible IS
TRUE AND approved IS
TRUE$$

CREATE PROCEDURE `query_user_welcome_pref`( IN `iid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT welcome
FROM owner
WHERE id = iid$$

CREATE PROCEDURE `query_yield_unit_exists`( IN `name` TEXT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM yield_unit
WHERE BINARY yield_unit = name$$

CREATE PROCEDURE `query_yield_unit_name`( IN `yid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT yield_unit
FROM yield_unit
WHERE id = yid$$

CREATE PROCEDURE `query_yield_unit_owner_exists`( IN `did` BIGINT, IN `uid` BIGINT )
    READS SQL DATA
    SQL SECURITY INVOKER
SELECT id
FROM yield_unit_owner
WHERE yield_unit = did
AND owner = uid$$

--
-- Functions
--
CREATE FUNCTION `get_aisle`(
`iid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE aislename text$$
SELECT aisle
INTO aislename
FROM aisles
WHERE id = iid$$

RETURN aislename$$

END$$

CREATE FUNCTION `get_category`(
`iid` BIGINT
) RETURNS char(200) CHARSET utf8
BEGIN 
DECLARE output CHAR(200)$$
SELECT category INTO output FROM category WHERE id = iid$$
RETURN output$$
END$$

CREATE FUNCTION `get_cuisine`(
`iid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE cuisinename TEXT$$
SELECT cuisine
INTO cuisinename
FROM cuisine
WHERE id = iid$$

RETURN cuisinename$$

END$$

CREATE FUNCTION `get_diet`(
`iid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE dietname text$$

SELECT diet
INTO dietname
FROM diet
WHERE id = iid$$

RETURN dietname$$

END$$

CREATE FUNCTION `get_image`(
`iid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE imagename TEXT$$

SELECT image
INTO imagename
FROM image
WHERE id = iid$$

RETURN imagename$$

END$$

CREATE FUNCTION `get_image_id`(`iimage` TEXT) RETURNS bigint(20)
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE imageid BIGINT$$

SELECT id
INTO imageid
FROM image
WHERE image = iimage$$

RETURN imageid$$

END$$

CREATE FUNCTION `get_ingredient`(
`iid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE ingname TEXT$$

SELECT ingredient
INTO ingname
FROM ingredient
WHERE id = iid$$

RETURN ingname$$

END$$

CREATE FUNCTION `get_ing_aisle`(`iid` BIGINT, `uid` BIGINT) RETURNS TEXT CHARSET latin1 NOT DETERMINISTIC READS SQL DATA SQL SECURITY INVOKER BEGIN DECLARE aislename text$$ SELECT get_aisle( aisle ) INTO aislename FROM ingredient_owner WHERE ingredient = iid AND owner = uid$$ RETURN aislename$$ END$$

CREATE FUNCTION `get_ing_aisle_order`(
`iid` BIGINT,
`uid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE aislerank int$$

SELECT aisle_order
INTO aislerank
FROM ingredient_owner
WHERE ingredient = iid
AND owner = uid$$

RETURN aislerank$$

END$$

CREATE FUNCTION `get_measure`(
`iid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE measurename TEXT$$

SELECT measure
INTO measurename
FROM measure
WHERE id = iid$$

RETURN measurename$$

END$$

CREATE FUNCTION `get_owner`(
`iid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE output TEXT$$

SELECT owner
INTO output
FROM owner
WHERE id = iid$$

RETURN output$$

END$$

CREATE FUNCTION `get_preprep`(
`iid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE preprepname TEXT$$

SELECT preprep
INTO preprepname
FROM preprep
WHERE id = iid$$

RETURN preprepname$$

END$$

CREATE FUNCTION `get_recipename`(
`iid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE output TEXT$$

SELECT name
INTO output
FROM recipe
WHERE id = iid$$

RETURN output$$

END$$

CREATE FUNCTION `get_recipe_owner`(
`iid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE rowner TEXT$$

SELECT owner
INTO rowner
FROM recipe
WHERE id = iid$$

RETURN rowner$$

END$$

CREATE FUNCTION `get_source`(
`iid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE sourcename TEXT$$

SELECT source
INTO sourcename
FROM source
WHERE id = iid$$

RETURN sourcename$$

END$$

CREATE FUNCTION `get_subcategory`(
`iid` BIGINT
) RETURNS char(200) CHARSET utf8
BEGIN DECLARE output CHAR( 200 ) $$

SELECT subcategory
INTO output
FROM subcategory
WHERE id = iid$$

RETURN output$$

END$$

CREATE FUNCTION `get_unit`(
`iid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE unitname TEXT$$

SELECT unit
INTO unitname
FROM unit
WHERE id = iid$$

RETURN unitname$$

END$$

CREATE FUNCTION `get_yield_unit`(
`iid` BIGINT
) RETURNS text CHARSET utf8
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN DECLARE yield_unitname TEXT$$

SELECT yield_unit
INTO yield_unitname
FROM yield_unit
WHERE id = iid$$

RETURN yield_unitname$$

END$$

CREATE PROCEDURE `query_sources` ( ) NOT DETERMINISTIC READS SQL DATA SQL SECURITY INVOKER SELECT source, id
FROM source
WHERE id
IN (

SELECT DISTINCT source
FROM recipe
)
ORDER BY source$$
$$

DELIMITER $$

-- --------------------------------------------------------

--
-- Table structure for table `aisles`
--

CREATE TABLE IF NOT EXISTS `aisles` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `aisle` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `aisles_aisle_key` (`aisle`(10))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category` text,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `category_owner`
--

CREATE TABLE IF NOT EXISTS `category_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` bigint(6) DEFAULT NULL,
  `owner` bigint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `commentid` bigint(20) NOT NULL AUTO_INCREMENT,
  `recipe` bigint(20) NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visible` tinyint(1) DEFAULT NULL,
  `owner` bigint(20) DEFAULT NULL,
  `checked` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`commentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `cuisine`
--

CREATE TABLE IF NOT EXISTS `cuisine` (
  `cuisine` text,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `cuisine_owner`
--

CREATE TABLE IF NOT EXISTS `cuisine_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuisine` bigint(6) DEFAULT NULL,
  `owner` bigint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cuisine` (`cuisine`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `diet`
--

CREATE TABLE IF NOT EXISTS `diet` (
  `diet` text NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `diet_owner`
--

CREATE TABLE IF NOT EXISTS `diet_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `diet` bigint(6) DEFAULT NULL,
  `owner` bigint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `diet` (`diet`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `excluded_ing`
--

CREATE TABLE IF NOT EXISTS `excluded_ing` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ing` bigint(20) DEFAULT NULL,
  `owner` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `excluded_ing_ing_fkey` (`ing`),
  KEY `excluded_ing_owner_fkey` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE IF NOT EXISTS `favourites` (
  `id` bigint(20) NOT NULL,
  `owner` bigint(20) DEFAULT NULL,
  `favid` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`favid`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE IF NOT EXISTS `ingredient` (
  `ingredient` text,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `ingredient_owner`
--

CREATE TABLE IF NOT EXISTS `ingredient_owner` (
  `ingredient` bigint(20) DEFAULT NULL,
  `owner` bigint(20) DEFAULT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `aisle` bigint(20) DEFAULT NULL,
  `sl` tinyint(1) DEFAULT NULL,
  `aisle_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ingredient_owner_aisle_fkey` (`aisle`),
  KEY `ingredient_owner_ingredient_fkey` (`ingredient`),
  KEY `ingredient_owner_owner_fkey` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `measure`
--

CREATE TABLE IF NOT EXISTS `measure` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `measure` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 $$

--
-- Dumping data for table `measure`
--

INSERT INTO `measure` (`id`, `measure`) VALUES
(6, 'Imperial'),
(7, 'Metric'),
(8, 'Metric (AU)'),
(9, 'Metric (UK)'),
(10, 'US')$$

-- --------------------------------------------------------

--
-- Table structure for table `measure_owner`
--

CREATE TABLE IF NOT EXISTS `measure_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `measure` bigint(6) DEFAULT NULL,
  `owner` bigint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `measure` (`measure`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu` text NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `owner` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `menu_recipe`
--

CREATE TABLE IF NOT EXISTS `menu_recipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` longtext,
  `recipe` bigint(20) DEFAULT NULL,
  `day` smallint(6) DEFAULT NULL,
  `rank` smallint(6) DEFAULT NULL,
  `menu` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_recipe_recipe_fkeyIdx` (`recipe`),
  KEY `menu` (`menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE IF NOT EXISTS `owner` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `owner` char(255) DEFAULT NULL,
  `lastlogin` date DEFAULT NULL,
  `password` text,
  `email` text,
  `regdate` date DEFAULT NULL,
  `fname` text,
  `lname` text,
  `toc` tinyint(1) DEFAULT NULL,
  `catt` tinyint(1) DEFAULT NULL,
  `measure` bigint(20) DEFAULT NULL,
  `paper` bigint(20) DEFAULT NULL,
  `datefmt` bigint(20) DEFAULT NULL,
  `ebtitle` text,
  `welcome` tinyint(1) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL,
  `approved` tinyint(1) DEFAULT NULL,
  `signup_date` date DEFAULT NULL,
  `pdf` tinyint(1) DEFAULT NULL,
  `rapp` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `owner_owner_key` (`owner`(10))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 $$

--
-- Dumping data for table `owner`
--
INSERT INTO `owner` (`owner`, `password`,`admin`, `approved`) VALUES
('mywrm', '$P$BOp/cs7eOs6awPehCCrU4O8rC9TycG1', 1, 1)$$

-- --------------------------------------------------------

--
-- Table structure for table `preprep`
--

CREATE TABLE IF NOT EXISTS `preprep` (
  `preprep` text,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `preprep_owner`
--

CREATE TABLE IF NOT EXISTS `preprep_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `preprep` bigint(6) DEFAULT NULL,
  `owner` bigint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `preprep` (`preprep`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `rating` text,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 $$

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`rating`, `id`) VALUES
('1 Star', 0),
('2 Stars', 1),
('3 Stars', 2),
('4 Stars', 3),
('5 Stars', 4)$$

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE IF NOT EXISTS `recipe` (
  `name` text,
  `directions` varchar(5000) DEFAULT NULL,
  `note` varchar(5000) DEFAULT NULL,
  `source` bigint(20) DEFAULT NULL,
  `cuisine` bigint(20) DEFAULT NULL,
  `rating` smallint(6) DEFAULT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `updated` date DEFAULT NULL,
  `yield` double(9,2) DEFAULT NULL,
  `yield_unit` bigint(20) DEFAULT NULL,
  `tried` tinyint(1) DEFAULT '0',
  `image` text,
  `measure` bigint(20) DEFAULT NULL,
  `url` text,
  `added` date DEFAULT NULL,
  `preptime` text,
  `owner` bigint(20) DEFAULT NULL,
  `total_ratings` bigint(20) DEFAULT '0',
  `pdf` text,
  `cooktime` text,
  `addedby` text,
  `visible` tinyint(1) DEFAULT '1',
  `approved` tinyint(1) DEFAULT '1',
  `public` tinyint(1) DEFAULT NULL,
  `video` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `recipe_cat_subcat`
--

CREATE TABLE IF NOT EXISTS `recipe_cat_subcat` (
  `recipe` bigint(20) DEFAULT NULL,
  `cat` bigint(20) DEFAULT NULL,
  `subcat` bigint(20) DEFAULT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `recipe_cat_subcat_cat_fkey` (`cat`),
  KEY `recipe_cat_subcat_subcat_fkey` (`subcat`),
  KEY `recipe` (`recipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `recipe_diet`
--

CREATE TABLE IF NOT EXISTS `recipe_diet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe` bigint(6) DEFAULT NULL,
  `diet` bigint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recipe_diet_recipe_fkeyIdx` (`recipe`),
  KEY `diet` (`diet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `recipe_image`
--

CREATE TABLE IF NOT EXISTS `recipe_image` (
  `recipe` bigint(6) DEFAULT NULL,
  `image` bigint(6) DEFAULT NULL,
  KEY `recipe` (`recipe`),
  KEY `image` (`image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8$$

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ing`
--

CREATE TABLE IF NOT EXISTS `recipe_ing` (
  `recipe` bigint(20) NOT NULL,
  `ing` bigint(20) NOT NULL,
  `unit` bigint(20) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantity` longtext,
  `preprep1` bigint(20) DEFAULT NULL,
  `preprep2` bigint(20) DEFAULT NULL,
  `quantity2` longtext,
  `unit2` bigint(20) DEFAULT NULL,
  `qtydec` decimal(10,3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recipe_ing_ing_fkeyIdx` (`ing`),
  KEY `recipe_ing_preprep1_fkeyIdx` (`preprep1`),
  KEY `recipe_ing_preprep2_fkeyIdx` (`preprep2`),
  KEY `recipe_ing_recipe_fkeyIdx` (`recipe`),
  KEY `recipe_ing_unit_fkeyIdx` (`unit`),
  KEY `recipe_ing_unit2_fkeyIdx` (`unit2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `recipe_rating`
--

CREATE TABLE IF NOT EXISTS `recipe_rating` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rater` bigint(20) NOT NULL,
  `rating` smallint(6) DEFAULT NULL,
  `recipe` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `recipe_rating_recipe_fkey` (`recipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `recipe_recipe`
--

CREATE TABLE IF NOT EXISTS `recipe_recipe` (
  `id` bigint(20) NOT NULL,
  `related_id` bigint(20) NOT NULL,
  `pid` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pid`),
  KEY `recipe_recipe_id_fkey` (`id`),
  KEY `recipe_recipe_related_id_fkey` (`related_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `server`
--

CREATE TABLE IF NOT EXISTS `server` (
  `server` text,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expire` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 $$

--
-- Dumping data for table `server`
--

INSERT INTO `server` (`server`, `id`, `expire`) VALUES
(NULL, 1, '2014-07-06')$$

-- --------------------------------------------------------

--
-- Table structure for table `shopping_list`
--

CREATE TABLE IF NOT EXISTS `shopping_list` (
  `list` text,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `owner` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `shopping_list_entry`
--

CREATE TABLE IF NOT EXISTS `shopping_list_entry` (
  `list` bigint(20) DEFAULT NULL,
  `entry` text,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ing` bigint(20) DEFAULT NULL,
  `recipe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shopping-list_entry_list_fkey` (`list`),
  KEY `shopping_list_entry_ing_fkey` (`ing`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `source`
--

CREATE TABLE IF NOT EXISTS `source` (
  `source` text NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `source_owner`
--

CREATE TABLE IF NOT EXISTS `source_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` bigint(6) DEFAULT NULL,
  `owner` bigint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `source` (`source`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE IF NOT EXISTS `subcategory` (
  `subcategory` text NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `subcategory_owner`
--

CREATE TABLE IF NOT EXISTS `subcategory_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subcategory` bigint(6) DEFAULT NULL,
  `owner` bigint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subcategory` (`subcategory`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
  `unit` text,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `unit_owner`
--

CREATE TABLE IF NOT EXISTS `unit_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` bigint(6) DEFAULT NULL,
  `owner` bigint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `unit` (`unit`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `yield_unit`
--

CREATE TABLE IF NOT EXISTS `yield_unit` (
  `yield_unit` text,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

-- --------------------------------------------------------

--
-- Table structure for table `yield_unit_owner`
--

CREATE TABLE IF NOT EXISTS `yield_unit_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yield_unit` bigint(6) DEFAULT NULL,
  `owner` bigint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `yield_unit` (`yield_unit`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 $$

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_owner`
--
ALTER TABLE `category_owner`
  ADD CONSTRAINT `category_owner_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_owner_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `owner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `cuisine_owner`
--
ALTER TABLE `cuisine_owner`
  ADD CONSTRAINT `cuisine_owner_ibfk_1` FOREIGN KEY (`cuisine`) REFERENCES `cuisine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cuisine_owner_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `owner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `diet_owner`
--
ALTER TABLE `diet_owner`
  ADD CONSTRAINT `diet_owner_ibfk_1` FOREIGN KEY (`diet`) REFERENCES `diet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `diet_owner_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `owner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `excluded_ing`
--
ALTER TABLE `excluded_ing`
  ADD CONSTRAINT `excluded_ing_ing_fkey` FOREIGN KEY (`ing`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `excluded_ing_owner_fkey` FOREIGN KEY (`owner`) REFERENCES `owner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `ingredient_owner`
--
ALTER TABLE `ingredient_owner`
  ADD CONSTRAINT `ingredient_owner_aisle_fkey` FOREIGN KEY (`aisle`) REFERENCES `aisles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ingredient_owner_ingredient_fkey` FOREIGN KEY (`ingredient`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ingredient_owner_owner_fkey` FOREIGN KEY (`owner`) REFERENCES `owner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `measure_owner`
--
ALTER TABLE `measure_owner`
  ADD CONSTRAINT `measure_owner_ibfk_1` FOREIGN KEY (`measure`) REFERENCES `measure` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `measure_owner_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `owner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `menu_recipe`
--
ALTER TABLE `menu_recipe`
  ADD CONSTRAINT `menu_recipe_ibfk_1` FOREIGN KEY (`menu`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_recipe_recipe_fkey` FOREIGN KEY (`recipe`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `preprep_owner`
--
ALTER TABLE `preprep_owner`
  ADD CONSTRAINT `preprep_owner_ibfk_1` FOREIGN KEY (`preprep`) REFERENCES `preprep` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `preprep_owner_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `owner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `recipe_cat_subcat`
--
ALTER TABLE `recipe_cat_subcat`
  ADD CONSTRAINT `recipe` FOREIGN KEY (`recipe`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_cat_subcat_cat_fkey` FOREIGN KEY (`cat`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_cat_subcat_ibfk_1` FOREIGN KEY (`recipe`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_cat_subcat_subcat_fkey` FOREIGN KEY (`subcat`) REFERENCES `subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `recipe_diet`
--
ALTER TABLE `recipe_diet`
  ADD CONSTRAINT `recipe_diet_ibfk_1` FOREIGN KEY (`recipe`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_diet_ibfk_2` FOREIGN KEY (`diet`) REFERENCES `diet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_diet_ibfk_3` FOREIGN KEY (`diet`) REFERENCES `diet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `recipe_image`
--
ALTER TABLE `recipe_image`
  ADD CONSTRAINT `recipe_image_ibfk_1` FOREIGN KEY (`recipe`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `recipe_ing`
--
ALTER TABLE `recipe_ing`
  ADD CONSTRAINT `recipe_ing_ing_fkey` FOREIGN KEY (`ing`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_ing_preprep1_fkey` FOREIGN KEY (`preprep1`) REFERENCES `preprep` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_ing_preprep2_fkey` FOREIGN KEY (`preprep2`) REFERENCES `preprep` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_ing_recipe_fkey` FOREIGN KEY (`recipe`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_ing_unit2_fkey` FOREIGN KEY (`unit2`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_ing_unit_fkey` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `recipe_rating`
--
ALTER TABLE `recipe_rating`
  ADD CONSTRAINT `recipe_rating_recipe_fkey` FOREIGN KEY (`recipe`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `recipe_recipe`
--
ALTER TABLE `recipe_recipe`
  ADD CONSTRAINT `recipe_recipe_id_fkey` FOREIGN KEY (`id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_recipe_related_id_fkey` FOREIGN KEY (`related_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `shopping_list_entry`
--
ALTER TABLE `shopping_list_entry`
  ADD CONSTRAINT `shopping-list_entry_list_fkey` FOREIGN KEY (`list`) REFERENCES `shopping_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shopping_list_entry_ing_fkey` FOREIGN KEY (`ing`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `source_owner`
--
ALTER TABLE `source_owner`
  ADD CONSTRAINT `source_owner_ibfk_1` FOREIGN KEY (`source`) REFERENCES `source` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `source_owner_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `owner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `subcategory_owner`
--
ALTER TABLE `subcategory_owner`
  ADD CONSTRAINT `subcategory_owner_ibfk_1` FOREIGN KEY (`subcategory`) REFERENCES `subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subcategory_owner_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `owner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `unit_owner`
--
ALTER TABLE `unit_owner`
  ADD CONSTRAINT `unit_owner_ibfk_1` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `unit_owner_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `owner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

--
-- Constraints for table `yield_unit_owner`
--
ALTER TABLE `yield_unit_owner`
  ADD CONSTRAINT `yield_unit_owner_ibfk_1` FOREIGN KEY (`yield_unit`) REFERENCES `yield_unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `yield_unit_owner_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `owner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE$$

ALTER TABLE owner ADD guest boolean$$
alter table owner add gpref boolean$$

CREATE PROCEDURE `query_upd_owner_guest` ( IN `newuser` TEXT ) NOT DETERMINISTIC MODIFIES SQL DATA SQL SECURITY INVOKER UPDATE owner SET guest = TRUE WHERE owner = newuser$$

CREATE PROCEDURE `query_upd_user_guest` ( ) NOT DETERMINISTIC MODIFIES SQL DATA SQL SECURITY INVOKER UPDATE owner SET guest = FALSE $$

CREATE PROCEDURE `query_update_owner_guest` ( IN `iid` BIGINT ) NOT DETERMINISTIC MODIFIES SQL DATA SQL SECURITY INVOKER UPDATE owner SET guest = TRUE WHERE id = iid$$

DROP PROCEDURE `query_user_extra_details` $$

CREATE PROCEDURE `query_user_extra_details` ( IN `uname` TEXT ) NOT DETERMINISTIC READS SQL DATA SQL SECURITY INVOKER SELECT lastlogin, admin, id, guest
FROM owner
WHERE BINARY owner = uname$$

CREATE PROCEDURE `query_owner_is_guest` ( IN `uname` TEXT ) NOT DETERMINISTIC READS SQL DATA SQL SECURITY INVOKER SELECT guest
FROM owner
WHERE owner = uname
AND guest IS
TRUE$$

DROP PROCEDURE `query_add_eboption_prefs` $$

CREATE PROCEDURE `query_add_eboption_prefs` ( IN `stoc` BOOLEAN, IN `scatt` BOOLEAN, IN `swelcome` BOOLEAN, IN `spdf` BOOLEAN, IN `srapp` BOOLEAN, IN `uid` BIGINT, IN `sgpref` BOOLEAN ) NOT DETERMINISTIC MODIFIES SQL DATA SQL SECURITY INVOKER UPDATE owner SET toc = stoc,
catt = scatt,
welcome = swelcome,
pdf = spdf,
rapp = srapp,
gpref = sgpref WHERE id = uid$$

DROP PROCEDURE `query_user_prefs` $$

CREATE PROCEDURE `query_user_prefs` ( IN `iid` BIGINT ) NOT DETERMINISTIC READS SQL DATA SQL SECURITY INVOKER SELECT toc, catt, datefmt, measure, ebtitle, paper, get_measure(
measure
) AS msname, pdf, rapp, numfmt, fracdec, region, groroz
FROM owner
WHERE id = iid$$

ALTER TABLE owner ADD COLUMN numfmt bigint,
ADD COLUMN fracdec bigint,
DROP COLUMN gpref$$

ALTER TABLE owner ADD COLUMN region bigint$$

DROP PROCEDURE `query_user_prefs` $$

CREATE PROCEDURE `query_user_prefs` ( IN `iid` BIGINT ) NOT DETERMINISTIC READS SQL DATA SQL SECURITY INVOKER SELECT toc, catt, datefmt, measure, ebtitle, paper, get_measure(
measure
) AS msname, pdf, rapp, numfmt, fracdec, region
FROM owner
WHERE id = iid$$

CREATE TABLE region(
`id` bigint( 20 ) NOT NULL AUTO_INCREMENT ,
`region` text,
PRIMARY KEY ( `id` )
)$$

ALTER TABLE `region` CHANGE `id` `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT $$

insert into region  (region) values('USA')$$
insert into region  (region) values('UK')$$
insert into region  (region) values('Australia')$$
insert into region  (region) values('New Zealand')$$
insert into region  (region) values('Metric')$$
insert into region  (region) values('Canada')$$

CREATE PROCEDURE `query_regions` ( ) NOT DETERMINISTIC READS SQL DATA SQL SECURITY INVOKER SELECT id, region
FROM region
ORDER BY region$$

CREATE PROCEDURE `query_add_region_pref` ( IN `rid` BIGINT, IN `oid` BIGINT ) NOT DETERMINISTIC MODIFIES SQL DATA SQL SECURITY INVOKER UPDATE owner SET region = rid WHERE id = oid$$

CREATE PROCEDURE `query_add_numfmt_pref` ( IN `nid` BIGINT, IN `oid` BIGINT ) NOT DETERMINISTIC MODIFIES SQL DATA SQL SECURITY INVOKER UPDATE owner SET numfmt = nid WHERE id = oid$$

CREATE PROCEDURE `query_add_fracdec_pref` ( IN `fid` BIGINT, IN `oid` BIGINT ) NOT DETERMINISTIC MODIFIES SQL DATA SQL SECURITY INVOKER UPDATE owner SET fracdec = fid WHERE id = oid$$

DROP PROCEDURE `query_add_eboption_prefs` $$

CREATE PROCEDURE `query_add_eboption_prefs` ( IN `stoc` BOOLEAN, IN `scatt` BOOLEAN, IN `swelcome` BOOLEAN, IN `spdf` BOOLEAN, IN `srapp` BOOLEAN, IN `uid` BIGINT ) NOT DETERMINISTIC MODIFIES SQL DATA SQL SECURITY INVOKER UPDATE owner SET toc = stoc,
catt = scatt,
welcome = swelcome,
pdf = spdf,
rapp = srapp WHERE id = uid$$

ALTER TABLE owner ADD COLUMN groroz bigint$$

CREATE TABLE IF NOT EXISTS `unit_base` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `unit` text NOT NULL,
  `base` text,
  `mmf` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8$$

INSERT INTO unit_base VALUES (140, 'cloves', 'clove', 'cv')$$
INSERT INTO unit_base VALUES (141, 'clove', 'clove', 'cv')$$
INSERT INTO unit_base VALUES (12, 'extra lg', 'extra large', 'xl')$$
INSERT INTO unit_base VALUES (100, 'ball', 'ball', 'bl')$$
INSERT INTO unit_base VALUES (106, 'blocks', 'block', 'bk')$$
INSERT INTO unit_base VALUES (109, 'bt', 'bottle', 'bt')$$
INSERT INTO unit_base VALUES (98, 'bg', 'bag', 'bg')$$
INSERT INTO unit_base VALUES (104, 'baskets', 'basket', 'bs')$$
INSERT INTO unit_base VALUES (101, 'bar', 'bar', 'br')$$
INSERT INTO unit_base VALUES (117, 'bulbs', 'bulb', 'bb')$$
INSERT INTO unit_base VALUES (111, 'boxes', 'box', 'bx')$$
INSERT INTO unit_base VALUES (103, 'basket', 'basket', 'bs')$$
INSERT INTO unit_base VALUES (124, 'cans', 'can', 'cn')$$
INSERT INTO unit_base VALUES (108, 'bottle', 'bottle', 'bt')$$
INSERT INTO unit_base VALUES (118, 'bulb', 'bulb', 'bb')$$
INSERT INTO unit_base VALUES (96, 'bags', 'bag', 'bg')$$
INSERT INTO unit_base VALUES (5, 'fluid oz', 'fluid ounce', 'fl')$$
INSERT INTO unit_base VALUES (125, 'can', 'can', 'cn')$$
INSERT INTO unit_base VALUES (163, 'dashes', 'dash', 'ds')$$
INSERT INTO unit_base VALUES (135, 'ct', 'carton', 'ct')$$
INSERT INTO unit_base VALUES (123, 'bn', 'bunch', 'bn')$$
INSERT INTO unit_base VALUES (132, 'carton', 'carton', 'ct')$$
INSERT INTO unit_base VALUES (3, 'fluid ounce', 'fluid ounce', 'fl')$$
INSERT INTO unit_base VALUES (122, 'bunch', 'bunch', 'bn')$$
INSERT INTO unit_base VALUES (121, 'bunchs', 'bunch', 'bn')$$
INSERT INTO unit_base VALUES (1, 'fl oz', 'fluid ounce', 'fl')$$
INSERT INTO unit_base VALUES (162, 'c', 'cup', 'c')$$
INSERT INTO unit_base VALUES (161, 'c.', 'cup', 'c')$$
INSERT INTO unit_base VALUES (6, 'fluid ozs', 'fluid ounce', 'fl')$$
INSERT INTO unit_base VALUES (160, 'cp', 'cup', 'c')$$
INSERT INTO unit_base VALUES (159, 'cps', 'cup', 'c')$$
INSERT INTO unit_base VALUES (158, 'cup', 'cup', 'c')$$
INSERT INTO unit_base VALUES (157, 'cups', 'cup', 'c')$$
INSERT INTO unit_base VALUES (147, 'cl', 'centiliter', 'cl')$$
INSERT INTO unit_base VALUES (149, 'c/ls', 'centiliter', 'cl')$$
INSERT INTO unit_base VALUES (142, 'cls', 'centiliter', 'cl')$$
INSERT INTO unit_base VALUES (137, 'centigrams', 'centigram', 'cg')$$
INSERT INTO unit_base VALUES (138, 'centigram', 'centigram', 'cg')$$
INSERT INTO unit_base VALUES (134, 'ctn', 'carton', 'ct')$$
INSERT INTO unit_base VALUES (107, 'bottles', 'bottle', 'bt')$$
INSERT INTO unit_base VALUES (133, 'ctns', 'carton', 'ct')$$
INSERT INTO unit_base VALUES (112, 'boxs', 'box', 'bx')$$
INSERT INTO unit_base VALUES (116, 'branches', 'branch', 'bc')$$
INSERT INTO unit_base VALUES (113, 'box', 'box', 'bx')$$
INSERT INTO unit_base VALUES (129, 'capfull', 'capful', 'cf')$$
INSERT INTO unit_base VALUES (115, 'branch', 'branch', 'bc')$$
INSERT INTO unit_base VALUES (130, 'capfulls', 'capful', 'cf')$$
INSERT INTO unit_base VALUES (156, 'cb', 'cube', 'cb')$$
INSERT INTO unit_base VALUES (154, 'cubes', 'cube', 'cb')$$
INSERT INTO unit_base VALUES (10, 'cap full', 'capful', 'cf')$$
INSERT INTO unit_base VALUES (155, 'cube', 'cube', 'cb')$$
INSERT INTO unit_base VALUES (144, 'centiliters', 'centiliter', 'cl')$$
INSERT INTO unit_base VALUES (126, 'cn', 'can', 'cn')$$
INSERT INTO unit_base VALUES (143, 'centilitres', 'centiliter', 'cl')$$
INSERT INTO unit_base VALUES (153, 'containers', 'container', 'co')$$
INSERT INTO unit_base VALUES (151, 'cm', 'centimeter', 'cm')$$
INSERT INTO unit_base VALUES (152, 'container', 'container', 'co')$$
INSERT INTO unit_base VALUES (13, 'dessert spoon', 'dessertspoon', 'd')$$
INSERT INTO unit_base VALUES (18, 'heaped cup', 'heaped cup', 'hc')$$
INSERT INTO unit_base VALUES (20, 'heaped c', 'heaped cup', 'hc')$$
INSERT INTO unit_base VALUES (33, 'heaped tbsp', 'heaped tablespoon', 'hT')$$
INSERT INTO unit_base VALUES (21, 'heap c', 'heaped cup', 'hc')$$
INSERT INTO unit_base VALUES (35, 'heaped tbs', 'heaped tablespoon', 'hT')$$
INSERT INTO unit_base VALUES (26, 'heaped dss', 'heaped dessertspoon', 'hD')$$
INSERT INTO unit_base VALUES (25, 'heaped dessertspoon', 'heaped dessertspoon', 'hD')$$
INSERT INTO unit_base VALUES (22, 'heaped dessert spoons', 'heaped dessertspoon', 'hD')$$
INSERT INTO unit_base VALUES (37, 'heaped tb', 'heaped tablespoon', 'hT')$$
INSERT INTO unit_base VALUES (17, 'heaping cup', 'heaped cup', 'hc')$$
INSERT INTO unit_base VALUES (31, 'heaped tablespoon', 'heaped tablespoon', 'hT')$$
INSERT INTO unit_base VALUES (32, 'heaping tbsp', 'heaped tablespoon', 'hT')$$
INSERT INTO unit_base VALUES (34, 'heaping tbs', 'heaped tablespoon', 'hT')$$
INSERT INTO unit_base VALUES (19, 'heaping c', 'heaped cup', 'hc')$$
INSERT INTO unit_base VALUES (43, 'heaped tsps', 'heaped teaspoon', 'ht')$$
INSERT INTO unit_base VALUES (45, 'heaped tsp', 'heaped teaspoon', 'ht')$$
INSERT INTO unit_base VALUES (30, 'heaping tablespoon', 'heaped tablespoon', 'hT')$$
INSERT INTO unit_base VALUES (47, 'heaped ts', 'heaped teaspoon', 'ht')$$
INSERT INTO unit_base VALUES (42, 'heaping tsps', 'heaped teaspoon', 'ht')$$
INSERT INTO unit_base VALUES (41, 'heaped teaspoon', 'heaped teaspoon', 'ht')$$
INSERT INTO unit_base VALUES (44, 'heaping tsp', 'heaped teaspoon', 'ht')$$
INSERT INTO unit_base VALUES (38, 'heaping teaspoons', 'heaped teaspoon', 'ht')$$
INSERT INTO unit_base VALUES (52, 'large bunch', 'large bunch', 'lB')$$
INSERT INTO unit_base VALUES (40, 'heaping teaspoon', 'heaped teaspoon', 'ht')$$
INSERT INTO unit_base VALUES (53, 'lg bunch', 'large bunch', 'lB')$$
INSERT INTO unit_base VALUES (61, 'lg can', 'large can', 'lc')$$
INSERT INTO unit_base VALUES (59, 'large cloves', 'large clove', 'lC')$$
INSERT INTO unit_base VALUES (54, 'large handful', 'large handful', 'lh')$$
INSERT INTO unit_base VALUES (55, 'large handfuls', 'large handful', 'lh')$$
INSERT INTO unit_base VALUES (60, 'lg cn', 'large can', 'lc')$$
INSERT INTO unit_base VALUES (56, 'lg handful', 'large handful', 'lh')$$
INSERT INTO unit_base VALUES (63, 'medium head', 'medium head', 'mH')$$
INSERT INTO unit_base VALUES (51, 'lg heads', 'large head', 'lH')$$
INSERT INTO unit_base VALUES (49, 'large heads', 'large head', 'lH')$$
INSERT INTO unit_base VALUES (50, 'lg head', 'large head', 'lH')$$
INSERT INTO unit_base VALUES (76, 'rounded ds', 'rounded dessertspoon', 'rd')$$
INSERT INTO unit_base VALUES (66, 'med heads', 'medium head', 'mH')$$
INSERT INTO unit_base VALUES (74, 'rounded dessertspoon', 'rounded dessertspoon', 'rd')$$
INSERT INTO unit_base VALUES (65, 'med head', 'medium head', 'mH')$$
INSERT INTO unit_base VALUES (70, 'round c', 'rounded cup', 'rc')$$
INSERT INTO unit_base VALUES (68, 'rounded cup', 'rounded cup', 'rc')$$
INSERT INTO unit_base VALUES (71, 'rounded dessert spoons', 'rounded dessertspoon', 'rd')$$
INSERT INTO unit_base VALUES (80, 'rounded tbsp', 'rounded tablespoon', 'rT')$$
INSERT INTO unit_base VALUES (75, 'rounded dss', 'rounded dessertspoon', 'rd')$$
INSERT INTO unit_base VALUES (81, 'rounded tbs', 'rounded tablespoon', 'rT')$$
INSERT INTO unit_base VALUES (77, 'rounded tablespoons', 'rounded tablespoon', 'rT')$$
INSERT INTO unit_base VALUES (78, 'rounded tablespoon', 'rounded tablespoon', 'rT')$$
INSERT INTO unit_base VALUES (86, 'rounded tsp', 'rounded teaspoon', 'rt')$$
INSERT INTO unit_base VALUES (87, 'rounded ts', 'rounded teaspoon', 'rt')$$
INSERT INTO unit_base VALUES (84, 'rounded teaspoon', 'rounded teaspoon', 'rt')$$
INSERT INTO unit_base VALUES (9, 'small can', 'small can', 'sc')$$
INSERT INTO unit_base VALUES (85, 'rounded tsps', 'rounded teaspoon', 'rt')$$
INSERT INTO unit_base VALUES (7, 'sm cn', 'small can', 'sc')$$
INSERT INTO unit_base VALUES (93, 'small handfuls', 'small handful', 'sH')$$
INSERT INTO unit_base VALUES (95, 'sm handfuls', 'small handful', 'sH')$$
INSERT INTO unit_base VALUES (94, 'sm handful', 'small handful', 'sH')$$
INSERT INTO unit_base VALUES (89, 'small heads', 'small head', 'th')$$
INSERT INTO unit_base VALUES (91, 'sm head', 'small head', 'th')$$
INSERT INTO unit_base VALUES (88, 'small head', 'small head', 'th')$$
INSERT INTO unit_base VALUES (339, 'ss', 'splash', 'ss')$$
INSERT INTO unit_base VALUES (399, 'co', 'container', 'co')$$
INSERT INTO unit_base VALUES (437, 'teaskanal', 'teaspoon', 'tk')$$
INSERT INTO unit_base VALUES (438, 'tsk', 'teaspoon', 'tk')$$
INSERT INTO unit_base VALUES (337, 'splashs', 'splash', 'ss')$$
INSERT INTO unit_base VALUES (336, 'splashes', 'splash', 'ss')$$
INSERT INTO unit_base VALUES (338, 'splash', 'splash', 'ss')$$
INSERT INTO unit_base VALUES (356, 'sr', 'strip', 'sr')$$
INSERT INTO unit_base VALUES (350, 'stick', 'stick', 'st')$$
INSERT INTO unit_base VALUES (384, 'tube', 'tube', 'tu')$$
INSERT INTO unit_base VALUES (439, 'blad', 'sheet', 'bl')$$
INSERT INTO unit_base VALUES (440, 'skivor', 'slice', 'sk')$$
INSERT INTO unit_base VALUES (441, 'msk', NULL, 'mk')$$
INSERT INTO unit_base VALUES (442, 'burk', 'jar', 'bk')$$
INSERT INTO unit_base VALUES (443, 'kaveskanal', NULL, 'kk')$$
INSERT INTO unit_base VALUES (444, 'squares', 'square', 'sq')$$
INSERT INTO unit_base VALUES (445, 'square', 'square', 'sq')$$
INSERT INTO unit_base VALUES (446, 'sq', 'square', 'sq')$$
INSERT INTO unit_base VALUES (447, 'small cans', 'small can', 'sc')$$
INSERT INTO unit_base VALUES (448, 'big pinch', 'large pinch', 'lp')$$
INSERT INTO unit_base VALUES (449, 'large pinch', 'large pinch', 'lp')$$
INSERT INTO unit_base VALUES (450, 'lp', 'large pinch', 'lp')$$
INSERT INTO unit_base VALUES (451, 'recipe', 'recipe', 'RC')$$
INSERT INTO unit_base VALUES (452, 'pkges', 'package', 'pk')$$
INSERT INTO unit_base VALUES (455, 'grains', 'grain', 'gn')$$
INSERT INTO unit_base VALUES (456, 'gn', 'grain', 'gn')$$
INSERT INTO unit_base VALUES (288, 'pkts', 'package', 'pk')$$
INSERT INTO unit_base VALUES (294, 'pkgs', 'package', 'pk')$$
INSERT INTO unit_base VALUES (297, 'pk', 'package', 'pk')$$
INSERT INTO unit_base VALUES (296, 'pkg', 'package', 'pk')$$
INSERT INTO unit_base VALUES (282, 'pn', 'pinch', 'pn')$$
INSERT INTO unit_base VALUES (279, 'pinches', 'pinch', 'pn')$$
INSERT INTO unit_base VALUES (187, 'drp', 'drop', 'dr')$$
INSERT INTO unit_base VALUES (280, 'pinchs', 'pinch', 'pn')$$
INSERT INTO unit_base VALUES (179, 'ds', 'dash', 'ds')$$
INSERT INTO unit_base VALUES (188, 'dr', 'drop', 'dr')$$
INSERT INTO unit_base VALUES (185, 'drop', 'drop', 'dr')$$
INSERT INTO unit_base VALUES (186, 'drps', 'drop', 'dr')$$
INSERT INTO unit_base VALUES (190, 'ea', 'each', 'ea')$$
INSERT INTO unit_base VALUES (165, 'dash', 'dash', 'ds')$$
INSERT INTO unit_base VALUES (334, 'slice', 'slice', 'sl')$$
INSERT INTO unit_base VALUES (333, 'slices', 'slice', 'sl')$$
INSERT INTO unit_base VALUES (189, 'each', 'each', 'ea')$$
INSERT INTO unit_base VALUES (283, 'pints', 'pint', 'pt')$$
INSERT INTO unit_base VALUES (202, 'floz', 'fluid ounce', 'fl')$$
INSERT INTO unit_base VALUES (286, 'pt.', 'pint', 'pt')$$
INSERT INTO unit_base VALUES (285, 'pts', 'pint', 'pt')$$
INSERT INTO unit_base VALUES (313, 'qts', 'quart', 'qt')$$
INSERT INTO unit_base VALUES (287, 'pt', 'pint', 'pt')$$
INSERT INTO unit_base VALUES (314, 'qt.', 'quart', 'qt')$$
INSERT INTO unit_base VALUES (205, 'galls', 'gallon', 'ga')$$
INSERT INTO unit_base VALUES (210, 'ga', 'gallon', 'ga')$$
INSERT INTO unit_base VALUES (311, 'quarts', 'quart', 'qt')$$
INSERT INTO unit_base VALUES (204, 'gallon', 'gallon', 'ga')$$
INSERT INTO unit_base VALUES (208, 'gal.', 'gallon', 'ga')$$
INSERT INTO unit_base VALUES (209, 'gal', 'gallon', 'ga')$$
INSERT INTO unit_base VALUES (271, 'oz.', 'ounce', 'oz')$$
INSERT INTO unit_base VALUES (270, 'ounce', 'ounce', 'oz')$$
INSERT INTO unit_base VALUES (207, 'gals', 'gallon', 'ga')$$
INSERT INTO unit_base VALUES (272, 'oz', 'ounce', 'oz')$$
INSERT INTO unit_base VALUES (269, 'ounces', 'ounce', 'oz')$$
INSERT INTO unit_base VALUES (305, 'lb.', 'pound', 'lb')$$
INSERT INTO unit_base VALUES (262, 'mls', 'milliliter', 'ml')$$
INSERT INTO unit_base VALUES (306, 'lb', 'pound', 'lb')$$
INSERT INTO unit_base VALUES (304, 'lbs', 'pound', 'lb')$$
INSERT INTO unit_base VALUES (303, 'pound', 'pound', 'lb')$$
INSERT INTO unit_base VALUES (263, 'milliliters', 'milliliter', 'ml')$$
INSERT INTO unit_base VALUES (265, 'milliliter', 'milliliter', 'ml')$$
INSERT INTO unit_base VALUES (174, 'd/ls', 'deciliter', 'dl')$$
INSERT INTO unit_base VALUES (173, 'd/l', 'deciliter', 'dl')$$
INSERT INTO unit_base VALUES (257, 'miligrams', 'milligram', 'mg')$$
INSERT INTO unit_base VALUES (170, 'decilitre', 'deciliter', 'dl')$$
INSERT INTO unit_base VALUES (169, 'deciliters', 'deciliter', 'dl')$$
INSERT INTO unit_base VALUES (247, 'l', 'litre', 'l')$$
INSERT INTO unit_base VALUES (168, 'decilitres', 'deciliter', 'dl')$$
INSERT INTO unit_base VALUES (242, 'liters', 'litre', 'l')$$
INSERT INTO unit_base VALUES (260, 'milligram', 'milligram', 'mg')$$
INSERT INTO unit_base VALUES (244, 'liter', 'litre', 'l')$$
INSERT INTO unit_base VALUES (243, 'litres', 'litre', 'l')$$
INSERT INTO unit_base VALUES (261, 'mg', 'milligram', 'mg')$$
INSERT INTO unit_base VALUES (214, 'g', 'gram', 'g')$$
INSERT INTO unit_base VALUES (258, 'milligrams', 'milligram', 'mg')$$
INSERT INTO unit_base VALUES (259, 'miligram', 'milligram', 'mg')$$
INSERT INTO unit_base VALUES (228, 'kgs', 'kilogram', 'kg')$$
INSERT INTO unit_base VALUES (213, 'gram', 'gram', 'g')$$
INSERT INTO unit_base VALUES (211, 'gms', 'gram', 'g')$$
INSERT INTO unit_base VALUES (212, 'grams', 'gram', 'g')$$
INSERT INTO unit_base VALUES (231, 'kg', 'kilogram', 'kg')$$
INSERT INTO unit_base VALUES (326, 'sm.', 'small', 'sm')$$
INSERT INTO unit_base VALUES (325, 'small', 'small', 'sm')$$
INSERT INTO unit_base VALUES (230, 'kilogram', 'kilogram', 'kg')$$
INSERT INTO unit_base VALUES (254, 'med', 'medium', 'md')$$
INSERT INTO unit_base VALUES (327, 'sm', 'small', 'sm')$$
INSERT INTO unit_base VALUES (252, 'medium', 'medium', 'md')$$
INSERT INTO unit_base VALUES (172, 'dl', 'deciliter', 'dl')$$
INSERT INTO unit_base VALUES (255, 'md', 'medium', 'md')$$
INSERT INTO unit_base VALUES (236, 'large', 'large', 'lg')$$
INSERT INTO unit_base VALUES (238, 'lg', 'large', 'lg')$$
INSERT INTO unit_base VALUES (175, 'dessertspoons', 'dessertspoon', 'd')$$
INSERT INTO unit_base VALUES (176, 'dessertspoon', 'dessertspoon', 'd')$$
INSERT INTO unit_base VALUES (167, 'dls', 'deciliter', 'dl')$$
INSERT INTO unit_base VALUES (181, 'dozen', 'dozen', 'dz')$$
INSERT INTO unit_base VALUES (180, 'dozens', 'dozen', 'dz')$$
INSERT INTO unit_base VALUES (191, 'ears', 'ear', 'er')$$
INSERT INTO unit_base VALUES (182, 'doz', 'dozen', 'dz')$$
INSERT INTO unit_base VALUES (178, 'dss', 'dessertspoon', 'd')$$
INSERT INTO unit_base VALUES (194, 'envelopes', 'envelope', 'en')$$
INSERT INTO unit_base VALUES (192, 'ear', 'ear', 'er')$$
INSERT INTO unit_base VALUES (198, 'fillets', 'fillet', 'ft')$$
INSERT INTO unit_base VALUES (193, 'er', 'ear', 'er')$$
INSERT INTO unit_base VALUES (196, 'ev', 'envelope', 'en')$$
INSERT INTO unit_base VALUES (197, 'en', 'envelope', 'en')$$
INSERT INTO unit_base VALUES (200, 'ft', 'fillet', 'ft')$$
INSERT INTO unit_base VALUES (215, 'handfuls', 'handful', 'hf')$$
INSERT INTO unit_base VALUES (217, 'hf', 'handful', 'hf')$$
INSERT INTO unit_base VALUES (218, 'heads', 'head', 'hd')$$
INSERT INTO unit_base VALUES (221, 'inches', 'inch', 'in')$$
INSERT INTO unit_base VALUES (223, 'inch', 'inch', 'in')$$
INSERT INTO unit_base VALUES (220, 'hd', 'head', 'hd')$$
INSERT INTO unit_base VALUES (224, 'in', 'inch', 'in')$$
INSERT INTO unit_base VALUES (225, 'jars', 'jar', 'jr')$$
INSERT INTO unit_base VALUES (222, 'inchs', 'inch', 'in')$$
INSERT INTO unit_base VALUES (234, 'knob', 'knob', 'kb')$$
INSERT INTO unit_base VALUES (227, 'jr', 'jar', 'jr')$$
INSERT INTO unit_base VALUES (301, 'pr', 'portion', 'pr')$$
INSERT INTO unit_base VALUES (233, 'knobs', 'knob', 'kb')$$
INSERT INTO unit_base VALUES (251, 'lf', 'leaf', 'lf')$$
INSERT INTO unit_base VALUES (239, 'leaf', 'leaf', 'lf')$$
INSERT INTO unit_base VALUES (240, 'leaves', 'leaf', 'lf')$$
INSERT INTO unit_base VALUES (250, 'lv', 'loaf', 'lv')$$
INSERT INTO unit_base VALUES (248, 'loaf', 'loaf', 'lv')$$
INSERT INTO unit_base VALUES (249, 'loaves', 'loaf', 'lv')$$
INSERT INTO unit_base VALUES (289, 'packets', 'package', 'pk')$$
INSERT INTO unit_base VALUES (291, 'packet', 'package', 'pk')$$
INSERT INTO unit_base VALUES (298, 'packages', 'package', 'pk')$$
INSERT INTO unit_base VALUES (292, 'package', 'package', 'pk')$$
INSERT INTO unit_base VALUES (171, 'deciliter', 'deciliter', 'dl')$$
INSERT INTO unit_base VALUES (245, 'litre', 'litre', 'l')$$
INSERT INTO unit_base VALUES (97, 'bag', 'bag', 'bg')$$
INSERT INTO unit_base VALUES (307, '#', 'pound', 'lb')$$
INSERT INTO unit_base VALUES (99, 'balls', 'ball', 'bl')$$
INSERT INTO unit_base VALUES (102, 'bars', 'bar', 'br')$$
INSERT INTO unit_base VALUES (389, 'bk', 'block', 'bk')$$
INSERT INTO unit_base VALUES (105, 'block', 'block', 'bk')$$
INSERT INTO unit_base VALUES (388, 'whole', 'whole', 'wh')$$
INSERT INTO unit_base VALUES (386, 'unit', 'container', 'co')$$
INSERT INTO unit_base VALUES (264, 'millilitres', 'milliliter', 'ml')$$
INSERT INTO unit_base VALUES (290, 'pkt', 'package', 'pk')$$
INSERT INTO unit_base VALUES (295, 'pkg.', 'package', 'pk')$$
INSERT INTO unit_base VALUES (281, 'pinch', 'pinch', 'pn')$$
INSERT INTO unit_base VALUES (184, 'drops', 'drop', 'dr')$$
INSERT INTO unit_base VALUES (164, 'dashs', 'dash', 'ds')$$
INSERT INTO unit_base VALUES (131, 'cartons', 'carton', 'ct')$$
INSERT INTO unit_base VALUES (120, 'bunches', 'bunch', 'bn')$$
INSERT INTO unit_base VALUES (335, 'sl', 'slice', 'sl')$$
INSERT INTO unit_base VALUES (29, 'heaped tablespoons', 'heaped tablespoon', 'hT')$$
INSERT INTO unit_base VALUES (256, 'mgs', 'milligram', 'mg')$$
INSERT INTO unit_base VALUES (136, 'cgs', 'centigram', 'cg')$$
INSERT INTO unit_base VALUES (139, 'cg', 'centigram', 'cg')$$
INSERT INTO unit_base VALUES (229, 'kilograms', 'kilogram', 'kg')$$
INSERT INTO unit_base VALUES (232, 'kilo', 'kilogram', 'kg')$$
INSERT INTO unit_base VALUES (253, 'med.', 'medium', 'md')$$
INSERT INTO unit_base VALUES (237, 'lg.', 'large', 'lg')$$
INSERT INTO unit_base VALUES (390, 'decigram', 'decigram', 'dg')$$
INSERT INTO unit_base VALUES (391, 'cubic centimeter', 'milliliter', 'cc')$$
INSERT INTO unit_base VALUES (378, 't', 'teaspoon', 'ts')$$
INSERT INTO unit_base VALUES (372, 'teaspoon', 'teaspoon', 'ts')$$
INSERT INTO unit_base VALUES (373, 'tsps', 'teaspoon', 'ts')$$
INSERT INTO unit_base VALUES (374, 'tsp.', 'teaspoon', 'ts')$$
INSERT INTO unit_base VALUES (375, 'tsp', 'teaspoon', 'ts')$$
INSERT INTO unit_base VALUES (376, 'ts', 'teaspoon', 'ts')$$
INSERT INTO unit_base VALUES (371, 'teaspoons', 'teaspoon', 'ts')$$
INSERT INTO unit_base VALUES (365, 'T', 'tablespoon', 'tb')$$
INSERT INTO unit_base VALUES (377, 't.', 'teaspoon', 'ts')$$
INSERT INTO unit_base VALUES (392, 'cc', 'milliliter', 'cc')$$
INSERT INTO unit_base VALUES (15, 'heaping cups', 'heaped cup', 'hc')$$
INSERT INTO unit_base VALUES (119, 'bb', 'bulb', 'bb')$$
INSERT INTO unit_base VALUES (110, 'btl', 'bottle', 'bt')$$
INSERT INTO unit_base VALUES (114, 'bx', 'box', 'bx')$$
INSERT INTO unit_base VALUES (36, 'heaping tb', 'heaped tablespoon', 'hT')$$
INSERT INTO unit_base VALUES (380, 'c.c', 'teaspoon', 'ts')$$
INSERT INTO unit_base VALUES (379, 'c.c.', 'teaspoon', 'ts')$$
INSERT INTO unit_base VALUES (364, 'c.s', 'tablespoon', 'tb')$$
INSERT INTO unit_base VALUES (359, 'tbsp.', 'tablespoon', 'tb')$$
INSERT INTO unit_base VALUES (360, 'tbsp', 'tablespoon', 'tb')$$
INSERT INTO unit_base VALUES (369, 'tbsn', 'tablespoon', 'tb')$$
INSERT INTO unit_base VALUES (361, 'tbs.', 'tablespoon', 'tb')$$
INSERT INTO unit_base VALUES (362, 'tbs', 'tablespoon', 'tb')$$
INSERT INTO unit_base VALUES (368, 'tblsp', 'tablespoon', 'tb')$$
INSERT INTO unit_base VALUES (363, 'tb', 'tablespoon', 'tb')$$
INSERT INTO unit_base VALUES (367, 'tabs', 'tablespoon', 'tb')$$
INSERT INTO unit_base VALUES (357, 'tablespoons', 'tablespoon', 'tb')$$
INSERT INTO unit_base VALUES (358, 'tablespoon', 'tablespoon', 'tb')$$
INSERT INTO unit_base VALUES (366, 'tab', 'tablespoon', 'tb')$$
INSERT INTO unit_base VALUES (4, 'fluid ounces', 'fluid ounce', 'fl')$$
INSERT INTO unit_base VALUES (2, 'fl ozs', 'fluid ounce', 'fl')$$
INSERT INTO unit_base VALUES (201, 'fl', 'fluid ounce', 'fl')$$
INSERT INTO unit_base VALUES (284, 'pint', 'pint', 'pt')$$
INSERT INTO unit_base VALUES (315, 'qt', 'quart', 'qt')$$
INSERT INTO unit_base VALUES (312, 'quart', 'quart', 'qt')$$
INSERT INTO unit_base VALUES (203, 'gallons', 'gallon', 'ga')$$
INSERT INTO unit_base VALUES (206, 'gall', 'gallon', 'ga')$$
INSERT INTO unit_base VALUES (268, 'ozs', 'ounce', 'oz')$$
INSERT INTO unit_base VALUES (302, 'pounds', 'pound', 'lb')$$
INSERT INTO unit_base VALUES (267, 'ml', 'milliliter', 'ml')$$
INSERT INTO unit_base VALUES (266, 'millilitre', 'milliliter', 'ml')$$
INSERT INTO unit_base VALUES (148, 'c/l', 'centiliter', 'cl')$$
INSERT INTO unit_base VALUES (127, 'capful', 'capful', 'cf')$$
INSERT INTO unit_base VALUES (128, 'capfuls', 'capful', 'cf')$$
INSERT INTO unit_base VALUES (393, 'cf', 'capful', 'cf')$$
INSERT INTO unit_base VALUES (145, 'centilitre', 'centiliter', 'cl')$$
INSERT INTO unit_base VALUES (146, 'centiliter', 'centiliter', 'cl')$$
INSERT INTO unit_base VALUES (150, 'cms', 'centimeter', 'cm')$$
INSERT INTO unit_base VALUES (14, 'dessert sp', 'dessertspoon', 'd')$$
INSERT INTO unit_base VALUES (177, 'dessertsp', 'dessertspoon', 'd')$$
INSERT INTO unit_base VALUES (381, 'tl', 'teaspoon', 'tl')$$
INSERT INTO unit_base VALUES (183, 'dz', 'dozen', 'dz')$$
INSERT INTO unit_base VALUES (195, 'envelope', 'envelope', 'en')$$
INSERT INTO unit_base VALUES (199, 'fillet', 'fillet', 'ft')$$
INSERT INTO unit_base VALUES (216, 'handful', 'handful', 'hf')$$
INSERT INTO unit_base VALUES (219, 'head', 'head', 'hd')$$
INSERT INTO unit_base VALUES (16, 'heaped cups', 'heaped cup', 'hc')$$
INSERT INTO unit_base VALUES (23, 'heaped dessert spoon', 'heaped dessertspoon', 'hD')$$
INSERT INTO unit_base VALUES (27, 'heaped ds', 'heaped dessertspoon', 'hD')$$
INSERT INTO unit_base VALUES (24, 'heaped dessertspoons', 'heaped dessertspoon', 'hD')$$
INSERT INTO unit_base VALUES (28, 'heaping tablespoons', 'heaped tablespoon', 'hT')$$
INSERT INTO unit_base VALUES (39, 'heaped teaspoons', 'heaped teaspoon', 'ht')$$
INSERT INTO unit_base VALUES (46, 'heaping ts', 'heaped teaspoon', 'ht')$$
INSERT INTO unit_base VALUES (226, 'jar', 'jar', 'jr')$$
INSERT INTO unit_base VALUES (235, 'kb', 'knob', 'kb')$$
INSERT INTO unit_base VALUES (62, 'large can', 'large can', 'lc')$$
INSERT INTO unit_base VALUES (58, 'large clove', 'large clove', 'lC')$$
INSERT INTO unit_base VALUES (57, 'lg handfuls', 'large handful', 'lh')$$
INSERT INTO unit_base VALUES (48, 'large head', 'large head', 'lH')$$
INSERT INTO unit_base VALUES (64, 'medium heads', 'medium head', 'mH')$$
INSERT INTO unit_base VALUES (293, 'pack', 'package', 'pk')$$
INSERT INTO unit_base VALUES (273, 'part', 'part', 'pT')$$
INSERT INTO unit_base VALUES (274, 'parts', 'part', 'pT')$$
INSERT INTO unit_base VALUES (394, 'mH', 'medium head', 'mH')$$
INSERT INTO unit_base VALUES (395, 'pT', 'part', 'pT')$$
INSERT INTO unit_base VALUES (278, 'pc', 'piece', 'pc')$$
INSERT INTO unit_base VALUES (275, 'pieces', 'piece', 'pc')$$
INSERT INTO unit_base VALUES (276, 'piece', 'piece', 'pc')$$
INSERT INTO unit_base VALUES (277, 'pcs', 'piece', 'pc')$$
INSERT INTO unit_base VALUES (300, 'portion', 'portion', 'pr')$$
INSERT INTO unit_base VALUES (299, 'portions', 'portion', 'pr')$$
INSERT INTO unit_base VALUES (310, 'pu', 'punnet', 'pu')$$
INSERT INTO unit_base VALUES (308, 'punnets', 'punnet', 'pu')$$
INSERT INTO unit_base VALUES (309, 'punnet', 'punnet', 'pu')$$
INSERT INTO unit_base VALUES (318, 'rs', 'rasher', 'rs')$$
INSERT INTO unit_base VALUES (317, 'rasher', 'rasher', 'rs')$$
INSERT INTO unit_base VALUES (316, 'rashers', 'rasher', 'rs')$$
INSERT INTO unit_base VALUES (319, 'ribs', 'rib', 'rb')$$
INSERT INTO unit_base VALUES (320, 'rib', 'rib', 'rb')$$
INSERT INTO unit_base VALUES (321, 'rb', 'rib', 'rb')$$
INSERT INTO unit_base VALUES (355, 'str', 'strip', 'sr')$$
INSERT INTO unit_base VALUES (348, 'sk', 'stalk', 'sk')$$
INSERT INTO unit_base VALUES (346, 'stalk', 'stalk', 'sk')$$
INSERT INTO unit_base VALUES (354, 'strip', 'strip', 'sr')$$
INSERT INTO unit_base VALUES (351, 'stk', 'stick', 'st')$$
INSERT INTO unit_base VALUES (353, 'strips', 'strip', 'sr')$$
INSERT INTO unit_base VALUES (347, 'stlk', 'stalk', 'sk')$$
INSERT INTO unit_base VALUES (349, 'sticks', 'stick', 'st')$$
INSERT INTO unit_base VALUES (387, 'un', 'unit', 'un')$$
INSERT INTO unit_base VALUES (352, 'st', 'stick', 'st')$$
INSERT INTO unit_base VALUES (383, 'tubes', 'tube', 'tu')$$
INSERT INTO unit_base VALUES (400, 'bc', 'branch', 'bc')$$
INSERT INTO unit_base VALUES (385, 'tu', 'tube', 'tu')$$
INSERT INTO unit_base VALUES (382, 'tub', 'container', 'co')$$
INSERT INTO unit_base VALUES (67, 'rounded cups', 'rounded cup', 'rc')$$
INSERT INTO unit_base VALUES (69, 'rounded c', 'rounded cup', 'rc')$$
INSERT INTO unit_base VALUES (396, 'rc', 'rounded cup', 'rc')$$
INSERT INTO unit_base VALUES (330, 'sb', 'slab', 'sb')$$
INSERT INTO unit_base VALUES (328, 'slabs', 'slab', 'sb')$$
INSERT INTO unit_base VALUES (329, 'slab', 'slab', 'sb')$$
INSERT INTO unit_base VALUES (73, 'rounded dessertspoons', 'rounded dessertspoon', 'rd')$$
INSERT INTO unit_base VALUES (72, 'rounded dessert spoon', 'rounded dessertspoon', 'rd')$$
INSERT INTO unit_base VALUES (79, 'rounded tbsps', 'rounded tablespoon', 'rT')$$
INSERT INTO unit_base VALUES (82, 'rounded tb', 'rounded tablespoon', 'rT')$$
INSERT INTO unit_base VALUES (83, 'rounded teaspoons', 'rounded teaspoon', 'rt')$$
INSERT INTO unit_base VALUES (322, 'sheets', 'sheet', 'sh')$$
INSERT INTO unit_base VALUES (323, 'sheet', 'sheet', 'sh')$$
INSERT INTO unit_base VALUES (324, 'sh', 'sheet', 'sh')$$
INSERT INTO unit_base VALUES (345, 'stalks', 'stalk', 'sk')$$
INSERT INTO unit_base VALUES (331, 'sleeve', 'sleeve', 'sv')$$
INSERT INTO unit_base VALUES (332, 'sleeves', 'sleeve', 'sv')$$
INSERT INTO unit_base VALUES (397, 'sv', 'sleeve', 'sv')$$
INSERT INTO unit_base VALUES (8, 'sm can', 'small can', 'sc')$$
INSERT INTO unit_base VALUES (92, 'small handful', 'small handful', 'sH')$$
INSERT INTO unit_base VALUES (90, 'sm heads', 'small head', 'th')$$
INSERT INTO unit_base VALUES (398, 'th', 'small head', 'th')$$
INSERT INTO unit_base VALUES (340, 'sprigs', 'sprig', 'sp')$$
INSERT INTO unit_base VALUES (341, 'sprig', 'sprig', 'sp')$$
INSERT INTO unit_base VALUES (342, 'sprg', 'sprig', 'sp')$$
INSERT INTO unit_base VALUES (343, 'spr', 'sprig', 'sp')$$
INSERT INTO unit_base VALUES (344, 'sp', 'sprig', 'sp')$$
INSERT INTO unit_base VALUES (401, 'bl', 'ball', 'bl')$$
INSERT INTO unit_base VALUES (402, 'br', 'bar', 'br')$$
INSERT INTO unit_base VALUES (403, 'bs', 'basket', 'bs')$$
INSERT INTO unit_base VALUES (404, 'cv', 'clove', 'cv')$$
INSERT INTO unit_base VALUES (405, 'd', 'dessertspoon', 'd')$$
INSERT INTO unit_base VALUES (406, 'lc', 'large can', 'lc')$$
INSERT INTO unit_base VALUES (407, 'lh', 'large handful', 'lh')$$
INSERT INTO unit_base VALUES (408, 'lH', 'large head', 'lH')$$
INSERT INTO unit_base VALUES (409, 'rd', 'rounded dessertspoon', 'rd')$$
INSERT INTO unit_base VALUES (410, 'rt', 'rounded teaspoon', 'rt')$$
INSERT INTO unit_base VALUES (411, 'rT', 'rounded tablespoon', 'rT')$$
INSERT INTO unit_base VALUES (412, 'sc', 'small can', 'sc')$$
INSERT INTO unit_base VALUES (413, 'sH', 'small handful', 'sH')$$
INSERT INTO unit_base VALUES (416, 'dg', 'decigram', 'dg')$$
INSERT INTO unit_base VALUES (417, 'xl', 'extra large', 'xl')$$
INSERT INTO unit_base VALUES (11, 'extra large', 'extra large', 'xl')$$
INSERT INTO unit_base VALUES (418, 'hc', 'heaped cup', 'hc')$$
INSERT INTO unit_base VALUES (419, 'hD', 'heaped dessertspoon', 'hD')$$
INSERT INTO unit_base VALUES (420, 'ht', 'heaped teaspoon', 'ht')$$
INSERT INTO unit_base VALUES (421, 'hT', 'heaped tablespoon', 'hT')$$
INSERT INTO unit_base VALUES (422, 'lB', 'large bunch', 'lB')$$
INSERT INTO unit_base VALUES (424, 'tin', 'tin', 'tn')$$
INSERT INTO unit_base VALUES (425, 'tn', 'tin', 'tn')$$
INSERT INTO unit_base VALUES (426, 'ms', 'pinch', 'ms')$$
INSERT INTO unit_base VALUES (370, 'el', 'tablespoon', 'el')$$
INSERT INTO unit_base VALUES (427, 'shot', 'shot', 'SH')$$
INSERT INTO unit_base VALUES (428, 'nagy fej', 'deciliter', 'nf')$$
INSERT INTO unit_base VALUES (429, 'gerezd', 'clove', 'gr')$$
INSERT INTO unit_base VALUES (423, 'gr', 'gram', 'g')$$
INSERT INTO unit_base VALUES (430, 'csipet', 'pinch', 'cs')$$
INSERT INTO unit_base VALUES (431, 'evokanal', 'tablespoon', 'ek')$$
INSERT INTO unit_base VALUES (433, 'cs', 'pinch', 'cs')$$
INSERT INTO unit_base VALUES (434, 'ek', 'tablespoon', 'ek')$$
INSERT INTO unit_base VALUES (435, 'tk', 'teaspoon', 'tk')$$
INSERT INTO unit_base VALUES (432, 'teáskanál', 'teaspoon', 'tk')$$
INSERT INTO unit_base VALUES (436, 'teakanal', 'teaspoon', 'tk')$$
INSERT INTO unit_base VALUES (457, 'flavors', 'flavour', 'fv')$$
INSERT INTO unit_base VALUES (459, 'glasses', 'glass', 'gl')$$
INSERT INTO unit_base VALUES (460, 'glass', 'glass', 'gl')$$
INSERT INTO unit_base VALUES (461, 'gl', 'glass', 'gl')$$
INSERT INTO unit_base VALUES (462, 'doboz', 'box', 'bx')$$
INSERT INTO unit_base VALUES (464, 'small bunch', 'small bunch', 'sB')$$
INSERT INTO unit_base VALUES (463, 'generous sprinkles', 'generous sprinkle', 'gs')$$
INSERT INTO unit_base VALUES (465, 'lingura', 'spoon', 'ln')$$
INSERT INTO unit_base VALUES (466, 'linguri', 'spoon', 'ln')$$
INSERT INTO unit_base VALUES (467, 'lingurita', 'teaspoon', 'lt')$$
INSERT INTO unit_base VALUES (468, 'legatura', 'bunch', 'le')$$
INSERT INTO unit_base VALUES (469, 'portie', 'portion', 'pr')$$
INSERT INTO unit_base VALUES (470, 'roll', 'roll', 'rl')$$
INSERT INTO unit_base VALUES (471, 'rl', 'roll', 'rl')$$
INSERT INTO unit_base VALUES (473, 'shake', 'shake', 'se')$$
INSERT INTO unit_base VALUES (472, 'shakes', 'shake', 'se')$$
INSERT INTO unit_base VALUES (474, 'tubs', 'container', 'co')$$
INSERT INTO unit_base VALUES (475, 'rack', 'rack', 'rk')$$
INSERT INTO unit_base VALUES (476, 'rk', 'rack', 'rk')$$
INSERT INTO unit_base VALUES (477, 'tins', 'tin', 'tn')$$
INSERT INTO unit_base VALUES (478, 'packaged', 'package', 'pk')$$
INSERT INTO unit_base VALUES (480, 'large cans', 'large can', 'lc')$$
INSERT INTO unit_base VALUES (479, 'big cans', 'large can', 'lc')$$

CREATE TABLE IF NOT EXISTS `email_history` (
`id` bigint( 20 ) NOT NULL AUTO_INCREMENT ,
`email` text NOT NULL ,
`owner` bigint( 20 ) NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = InnoDB DEFAULT CHARSET = utf8$$

ALTER TABLE `email_history` ADD CONSTRAINT `email_history_ibfk_1` FOREIGN KEY ( `owner` ) REFERENCES `owner` ( `id` ) ON DELETE CASCADE ON UPDATE CASCADE$$

ALTER TABLE `email_history` ADD `name` TEXT NOT NULL $$

CREATE PROCEDURE `query_delete_unused`()
BEGIN

delete from category_owner where category not in(select distinct cat from recipe_cat_subcat where cat is not null) and id!=20;

delete from category where id not in(select distinct cat from recipe_cat_subcat where cat is not null) and id!=20;

delete from subcategory_owner where subcategory not in(select distinct subcat from recipe_cat_subcat where subcat is not null) and id!=32;

delete from subcategory where id not in(select distinct subcat from recipe_cat_subcat where subcat is not null) and id!=32;

delete from cuisine_owner where cuisine not in(select distinct cuisine from recipe where cuisine is not null);

delete from cuisine where id not in(select distinct cuisine from recipe where cuisine is not null);

delete from diet_owner where diet not in(select distinct diet from recipe_diet where diet is not null);

delete from diet where id not in(select distinct diet from recipe_diet where diet is not null);

delete from measure_owner where measure not in(select distinct measure from recipe where measure is not null);

delete from measure where id not in(select distinct measure from recipe where measure is not null);

delete from ingredient_owner where sl is false and ingredient not in(select distinct ing from recipe_ing where ing is not null);

delete from ingredient where id not in(select distinct ingredient from ingredient_owner where ingredient is not null);

delete from source_owner where source not in(select distinct source from recipe where source is not null);

delete from source where id not in(select distinct source from recipe where source is not null);

delete from unit_owner where unit not in(select distinct unit from recipe_ing where unit is not null);

delete from unit where id not in(select distinct unit from recipe_ing where unit is not null);

delete from yield_unit_owner where yield_unit not in(select distinct yield_unit from recipe where yield_unit is not null);

delete from yield_unit where id not in(select distinct yield_unit from recipe where yield_unit is not null);

delete from preprep_owner where preprep not in(select distinct preprep1 from recipe_ing where preprep1 is not null union select distinct preprep2 from recipe_ing where preprep2 is not null);

delete from preprep where id not in(select distinct preprep1 from recipe_ing where preprep1 is not null union select distinct preprep2 from recipe_ing where preprep2 is not null);

END$$
ALTER TABLE `menu_recipe` ADD `meal` TEXT$$
DROP PROCEDURE IF EXISTS `query_add_menu_recipe`$$
DROP PROCEDURE IF EXISTS `query_menu`$$
ALTER TABLE owner ADD popovers BOOLEAN DEFAULT true$$
UPDATE owner SET popovers=true$$
DROP PROCEDURE `query_user_prefs`$$ 
CREATE PROCEDURE `query_user_prefs`(IN `iid` BIGINT) NOT DETERMINISTIC READS SQL DATA SQL SECURITY INVOKER SELECT toc, catt, datefmt, measure, ebtitle, paper, get_measure( measure ) AS msname, pdf, rapp, numfmt, fracdec, region, groroz, popovers FROM owner WHERE id = iid$$

DROP PROCEDURE `query_recipe_cats`$$

CREATE PROCEDURE `query_recipe_cats` ( IN `iid` BIGINT ) NOT DETERMINISTIC READS SQL DATA SQL SECURITY INVOKER SELECT get_category(
cat
) AS category, get_subcategory(
subcat
) AS subcategory
FROM recipe_cat_subcat
WHERE recipe = iid
ORDER BY subcat$$
DELIMITER ;