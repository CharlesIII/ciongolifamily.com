CREATE TABLE aisles (
    id bigint NOT NULL,
    aisle text
);


ALTER TABLE public.aisles OWNER TO postgres;

--
-- Name: aisles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE aisles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.aisles_id_seq OWNER TO postgres;

--
-- Name: aisles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE aisles_id_seq OWNED BY aisles.id;


--
-- Name: category; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE category (
    category text,
    id bigint NOT NULL
);


ALTER TABLE public.category OWNER TO postgres;

--
-- Name: category_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE category_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.category_id_seq OWNER TO postgres;

--
-- Name: category_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE category_id_seq OWNED BY category.id;


--
-- Name: category_owner; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE category_owner (
    category bigint,
    owner bigint,
    id bigint NOT NULL
);


ALTER TABLE public.category_owner OWNER TO postgres;

--
-- Name: category_owner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE category_owner_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.category_owner_id_seq OWNER TO postgres;

--
-- Name: category_owner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE category_owner_id_seq OWNED BY category_owner.id;


--
-- Name: comments; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE comments (
    commentid bigint NOT NULL,
    recipe bigint NOT NULL,
    comment text NOT NULL,
    date timestamp without time zone NOT NULL,
    visible boolean,
    owner bigint,
    checked boolean
);


ALTER TABLE public.comments OWNER TO postgres;

--
-- Name: comments_commentid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE comments_commentid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.comments_commentid_seq OWNER TO postgres;

--
-- Name: comments_commentid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE comments_commentid_seq OWNED BY comments.commentid;


--
-- Name: cuisine; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cuisine (
    cuisine text,
    id bigint NOT NULL
);


ALTER TABLE public.cuisine OWNER TO postgres;

--
-- Name: cuisine_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cuisine_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cuisine_id_seq OWNER TO postgres;

--
-- Name: cuisine_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cuisine_id_seq OWNED BY cuisine.id;


--
-- Name: cuisine_owner; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cuisine_owner (
    cuisine bigint,
    owner bigint,
    id bigint NOT NULL
);


ALTER TABLE public.cuisine_owner OWNER TO postgres;

--
-- Name: cuisine_owner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cuisine_owner_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cuisine_owner_id_seq OWNER TO postgres;

--
-- Name: cuisine_owner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cuisine_owner_id_seq OWNED BY cuisine_owner.id;


--
-- Name: diet; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diet (
    diet text NOT NULL,
    id bigint NOT NULL
);


ALTER TABLE public.diet OWNER TO postgres;

--
-- Name: diet_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diet_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.diet_id_seq OWNER TO postgres;

--
-- Name: diet_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diet_id_seq OWNED BY diet.id;


--
-- Name: diet_owner; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diet_owner (
    diet bigint,
    owner bigint,
    id bigint NOT NULL
);


ALTER TABLE public.diet_owner OWNER TO postgres;

--
-- Name: diet_owner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diet_owner_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.diet_owner_id_seq OWNER TO postgres;

--
-- Name: diet_owner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diet_owner_id_seq OWNED BY diet_owner.id;


--
-- Name: excluded_ing; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE excluded_ing (
    id bigint NOT NULL,
    ing bigint,
    owner bigint
);


ALTER TABLE public.excluded_ing OWNER TO postgres;

--
-- Name: excluded_ing_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE excluded_ing_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.excluded_ing_id_seq OWNER TO postgres;

--
-- Name: excluded_ing_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE excluded_ing_id_seq OWNED BY excluded_ing.id;


--
-- Name: favourites; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE favourites (
    id bigint NOT NULL,
    owner bigint,
    favid bigint NOT NULL
);


ALTER TABLE public.favourites OWNER TO postgres;

--
-- Name: favourites_favid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE favourites_favid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.favourites_favid_seq OWNER TO postgres;

--
-- Name: favourites_favid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE favourites_favid_seq OWNED BY favourites.favid;


--
-- Name: image; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE image (
    image text NOT NULL,
    id bigint NOT NULL
);


ALTER TABLE public.image OWNER TO postgres;

--
-- Name: image_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE image_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.image_id_seq OWNER TO postgres;

--
-- Name: image_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE image_id_seq OWNED BY image.id;


--
-- Name: ingredient; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ingredient (
    ingredient text,
    id bigint NOT NULL
);


ALTER TABLE public.ingredient OWNER TO postgres;

--
-- Name: ingredient_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ingredient_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ingredient_id_seq OWNER TO postgres;

--
-- Name: ingredient_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE ingredient_id_seq OWNED BY ingredient.id;


--
-- Name: ingredient_owner; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ingredient_owner (
    ingredient bigint,
    owner bigint,
    id bigint NOT NULL,
    aisle bigint,
    sl boolean,
    aisle_order bigint
);


ALTER TABLE public.ingredient_owner OWNER TO postgres;

--
-- Name: ingredient_owner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ingredient_owner_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ingredient_owner_id_seq OWNER TO postgres;

--
-- Name: ingredient_owner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE ingredient_owner_id_seq OWNED BY ingredient_owner.id;


--
-- Name: measure; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE measure (
    id bigint NOT NULL,
    measure text NOT NULL
);


ALTER TABLE public.measure OWNER TO postgres;

--
-- Name: measure_owner; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE measure_owner (
    measure bigint,
    owner bigint,
    id bigint NOT NULL
);


ALTER TABLE public.measure_owner OWNER TO postgres;

--
-- Name: measure_owner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE measure_owner_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.measure_owner_id_seq OWNER TO postgres;

--
-- Name: measure_owner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE measure_owner_id_seq OWNED BY measure_owner.id;


--
-- Name: measures_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE measures_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.measures_id_seq OWNER TO postgres;

--
-- Name: measures_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE measures_id_seq OWNED BY measure.id;


--
-- Name: menu; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE menu (
    menu text NOT NULL,
    id bigint NOT NULL,
    owner bigint NOT NULL
);


ALTER TABLE public.menu OWNER TO postgres;

--
-- Name: menu_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE menu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.menu_id_seq OWNER TO postgres;

--
-- Name: menu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE menu_id_seq OWNED BY menu.id;


--
-- Name: menu_recipe; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE menu_recipe (
    id bigint NOT NULL,
    link text,
    recipe bigint,
    day smallint,
    rank smallint,
    menu bigint
);


ALTER TABLE public.menu_recipe OWNER TO postgres;

--
-- Name: menu_recipe_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE menu_recipe_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.menu_recipe_id_seq OWNER TO postgres;

--
-- Name: menu_recipe_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE menu_recipe_id_seq OWNED BY menu_recipe.id;


--
-- Name: owner; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE owner
(
  id bigserial NOT NULL,
  owner text,
  lastlogin date,
  email text,
  regdate date,
  fname text,
  lname text,
  toc boolean,
  catt boolean,
  datefmt bigint,
  measure bigint,
  ebtitle text,
  paper bigint,
  password text,
  welcome boolean,
  signup_date date,
  mywrm_owner boolean,
  login_from text,
  dbowner text,
  dboid bigint,
  admin boolean,
  pdf boolean,
  rapp boolean,
  guest boolean,
  numfmt bigint,
  fracdec bigint,
  region bigint,
  groroz bigint,
  approved boolean,
  CONSTRAINT owner_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);

ALTER TABLE public.owner OWNER TO postgres;

--
-- Name: preprep; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE preprep (
    preprep text,
    id bigint NOT NULL
);


ALTER TABLE public.preprep OWNER TO postgres;

--
-- Name: preprep_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE preprep_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.preprep_id_seq OWNER TO postgres;

--
-- Name: preprep_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE preprep_id_seq OWNED BY preprep.id;


--
-- Name: preprep_owner; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE preprep_owner (
    preprep bigint,
    owner bigint,
    id bigint NOT NULL
);


ALTER TABLE public.preprep_owner OWNER TO postgres;

--
-- Name: preprep_owner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE preprep_owner_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.preprep_owner_id_seq OWNER TO postgres;

--
-- Name: preprep_owner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE preprep_owner_id_seq OWNED BY preprep_owner.id;


--
-- Name: rating; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE rating (
    rating text,
    id integer NOT NULL
);


ALTER TABLE public.rating OWNER TO postgres;

--
-- Name: rating_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE rating_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.rating_id_seq OWNER TO postgres;

--
-- Name: rating_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE rating_id_seq OWNED BY rating.id;


--
-- Name: recipe; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE recipe (
    name text,
    directions character varying,
    note character varying,
    source bigint,
    cuisine bigint,
    rating smallint,
    id bigint NOT NULL,
    updated date,
    yield numeric(9,2),
    yield_unit bigint,
    tried boolean DEFAULT false,
    measure bigint,
    url text,
    added date DEFAULT now(),
    preptime text,
    owner bigint,
    total_ratings bigint DEFAULT 0,
    pdf text,
    cooktime text,
    addedby text,
    visible boolean DEFAULT true,
    approved boolean DEFAULT true,
    video text,
    public boolean
);


ALTER TABLE public.recipe OWNER TO postgres;

--
-- Name: recipe_cat_subcat; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE recipe_cat_subcat (
    recipe bigint,
    cat bigint,
    subcat bigint,
    id bigint NOT NULL
);


ALTER TABLE public.recipe_cat_subcat OWNER TO postgres;

--
-- Name: recipe_cat_subcat_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE recipe_cat_subcat_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.recipe_cat_subcat_id_seq OWNER TO postgres;

--
-- Name: recipe_cat_subcat_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE recipe_cat_subcat_id_seq OWNED BY recipe_cat_subcat.id;


--
-- Name: recipe_diet; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE recipe_diet (
    id integer NOT NULL,
    recipe smallint,
    diet smallint
);


ALTER TABLE public.recipe_diet OWNER TO postgres;

--
-- Name: recipe_diet_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE recipe_diet_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.recipe_diet_id_seq OWNER TO postgres;

--
-- Name: recipe_diet_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE recipe_diet_id_seq OWNED BY recipe_diet.id;


--
-- Name: recipe_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE recipe_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.recipe_id_seq OWNER TO postgres;

--
-- Name: recipe_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE recipe_id_seq OWNED BY recipe.id;


--
-- Name: recipe_image; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE recipe_image (
    recipe bigint NOT NULL,
    image bigint NOT NULL
);


ALTER TABLE public.recipe_image OWNER TO postgres;

--
-- Name: recipe_ing; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE recipe_ing (
    recipe bigint NOT NULL,
    ing bigint NOT NULL,
    unit bigint,
    id bigint NOT NULL,
    quantity text,
    preprep1 bigint,
    preprep2 bigint,
    quantity2 text,
    unit2 bigint,
    qtydec numeric(10,3)
);


ALTER TABLE public.recipe_ing OWNER TO postgres;

--
-- Name: recipe_ing_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE recipe_ing_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.recipe_ing_id_seq OWNER TO postgres;

--
-- Name: recipe_ing_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE recipe_ing_id_seq OWNED BY recipe_ing.id;


--
-- Name: recipe_rating; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE recipe_rating (
    id bigint NOT NULL,
    rater bigint NOT NULL,
    rating smallint,
    recipe bigint NOT NULL
);


ALTER TABLE public.recipe_rating OWNER TO postgres;

--
-- Name: recipe_rating_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE recipe_rating_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.recipe_rating_id_seq OWNER TO postgres;

--
-- Name: recipe_rating_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE recipe_rating_id_seq OWNED BY recipe_rating.id;


--
-- Name: recipe_recipe; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE recipe_recipe (
    id bigint NOT NULL,
    related_id bigint NOT NULL
);


ALTER TABLE public.recipe_recipe OWNER TO postgres;

--
-- Name: server; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE server (
    server text,
    id integer NOT NULL,
    expire text
);


ALTER TABLE public.server OWNER TO postgres;

--
-- Name: server_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE server_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.server_id_seq OWNER TO postgres;

--
-- Name: server_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE server_id_seq OWNED BY server.id;


--
-- Name: shopping_list_entry; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE shopping_list_entry (
    list bigint,
    entry text,
    id bigint NOT NULL,
    ing bigint,
    recipe bigint
);


ALTER TABLE public.shopping_list_entry OWNER TO postgres;

--
-- Name: shopping-list_entry_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "shopping-list_entry_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."shopping-list_entry_id_seq" OWNER TO postgres;

--
-- Name: shopping-list_entry_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "shopping-list_entry_id_seq" OWNED BY shopping_list_entry.id;


--
-- Name: shopping_list; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE shopping_list (
    list text,
    id bigint NOT NULL,
    owner bigint
);


ALTER TABLE public.shopping_list OWNER TO postgres;

--
-- Name: shopping_list_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE shopping_list_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shopping_list_id_seq OWNER TO postgres;

--
-- Name: shopping_list_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE shopping_list_id_seq OWNED BY shopping_list.id;


--
-- Name: source; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE source (
    source text NOT NULL,
    id bigint NOT NULL
);


ALTER TABLE public.source OWNER TO postgres;

--
-- Name: source_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE source_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.source_id_seq OWNER TO postgres;

--
-- Name: source_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE source_id_seq OWNED BY source.id;


--
-- Name: source_owner; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE source_owner (
    source bigint,
    owner bigint,
    id bigint NOT NULL
);


ALTER TABLE public.source_owner OWNER TO postgres;

--
-- Name: source_owner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE source_owner_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.source_owner_id_seq OWNER TO postgres;

--
-- Name: source_owner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE source_owner_id_seq OWNED BY source_owner.id;


--
-- Name: subcategory; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE subcategory (
    subcategory text NOT NULL,
    id bigint NOT NULL
);


ALTER TABLE public.subcategory OWNER TO postgres;

--
-- Name: subcategory_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE subcategory_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.subcategory_id_seq OWNER TO postgres;

--
-- Name: subcategory_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE subcategory_id_seq OWNED BY subcategory.id;


--
-- Name: subcategory_owner; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE subcategory_owner (
    subcategory bigint,
    owner bigint,
    id bigint NOT NULL
);


ALTER TABLE public.subcategory_owner OWNER TO postgres;

--
-- Name: subcategory_owner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE subcategory_owner_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.subcategory_owner_id_seq OWNER TO postgres;

--
-- Name: subcategory_owner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE subcategory_owner_id_seq OWNED BY subcategory_owner.id;


--
-- Name: unit; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE unit (
    unit text,
    id bigint NOT NULL
);


ALTER TABLE public.unit OWNER TO postgres;

--
-- Name: unit_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE unit_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.unit_id_seq OWNER TO postgres;

--
-- Name: unit_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE unit_id_seq OWNED BY unit.id;


--
-- Name: unit_owner; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE unit_owner (
    unit bigint,
    owner bigint,
    id bigint NOT NULL
);


ALTER TABLE public.unit_owner OWNER TO postgres;

--
-- Name: unit_owner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE unit_owner_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.unit_owner_id_seq OWNER TO postgres;

--
-- Name: unit_owner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE unit_owner_id_seq OWNED BY unit_owner.id;


--
-- Name: yield_unit; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE yield_unit (
    yield_unit text,
    id bigint NOT NULL
);


ALTER TABLE public.yield_unit OWNER TO postgres;

--
-- Name: yield_unit_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE yield_unit_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.yield_unit_id_seq OWNER TO postgres;

--
-- Name: yield_unit_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE yield_unit_id_seq OWNED BY yield_unit.id;


--
-- Name: yield_unit_owner; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE yield_unit_owner (
    yield_unit bigint,
    owner bigint,
    id bigint NOT NULL
);


ALTER TABLE public.yield_unit_owner OWNER TO postgres;


CREATE FUNCTION get_aisle(bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT aisle FROM aisles WHERE id=$1 $_$;


ALTER FUNCTION public.get_aisle(bigint) OWNER TO postgres;

--
-- Name: get_category(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_category(bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT category FROM category WHERE id=$1 $_$;


ALTER FUNCTION public.get_category(bigint) OWNER TO postgres;

--
-- Name: get_cuisine(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_cuisine(bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT cuisine FROM cuisine WHERE id=$1$_$;


ALTER FUNCTION public.get_cuisine(bigint) OWNER TO postgres;

--
-- Name: get_diet(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_diet(bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT diet FROM diet WHERE id=$1$_$;


ALTER FUNCTION public.get_diet(bigint) OWNER TO postgres;

--
-- Name: get_image(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_image(bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT image FROM image WHERE id=$1$_$;


ALTER FUNCTION public.get_image(bigint) OWNER TO postgres;

--
-- Name: get_image_id(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_image_id(text) RETURNS bigint
    LANGUAGE sql
    AS $_$SELECT id FROM image WHERE image=$1 $_$;


ALTER FUNCTION public.get_image_id(text) OWNER TO postgres;

--
-- Name: get_ing_aisle(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_ing_aisle(bigint, bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT get_aisle(aisle) as aisle FROM ingredient_owner WHERE ingredient=$1 and owner=$2$_$;


ALTER FUNCTION public.get_ing_aisle(bigint, bigint) OWNER TO postgres;

--
-- Name: get_ing_aisle_order(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_ing_aisle_order(bigint, bigint) RETURNS bigint
    LANGUAGE sql
    AS $_$SELECT aisle_order FROM ingredient_owner WHERE ingredient=$1 and owner=$2$_$;


ALTER FUNCTION public.get_ing_aisle_order(bigint, bigint) OWNER TO postgres;

--
-- Name: get_ingredient(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_ingredient(bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT ingredient FROM ingredient WHERE id=$1$_$;


ALTER FUNCTION public.get_ingredient(bigint) OWNER TO postgres;

--
-- Name: get_measure(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_measure(bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT measure FROM measure WHERE id=$1$_$;


ALTER FUNCTION public.get_measure(bigint) OWNER TO postgres;

--
-- Name: get_owner(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_owner(bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT owner FROM owner WHERE id=$1$_$;


ALTER FUNCTION public.get_owner(bigint) OWNER TO postgres;

--
-- Name: get_preprep(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_preprep(bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT preprep FROM preprep WHERE id=$1$_$;


ALTER FUNCTION public.get_preprep(bigint) OWNER TO postgres;

--
-- Name: get_recipe_owner(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_recipe_owner(bigint) RETURNS bigint
    LANGUAGE sql
    AS $_$select owner from recipe where id = $1$_$;


ALTER FUNCTION public.get_recipe_owner(bigint) OWNER TO postgres;

--
-- Name: get_recipename(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_recipename(bigint) RETURNS character
    LANGUAGE sql
    AS $_$select name from recipe where id = $1$_$;


ALTER FUNCTION public.get_recipename(bigint) OWNER TO postgres;

--
-- Name: get_source(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_source(bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT source FROM source WHERE id=$1$_$;


ALTER FUNCTION public.get_source(bigint) OWNER TO postgres;

--
-- Name: get_subcategory(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_subcategory(bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT subcategory FROM subcategory WHERE id=$1$_$;


ALTER FUNCTION public.get_subcategory(bigint) OWNER TO postgres;

--
-- Name: get_unit(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_unit(bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT unit FROM unit WHERE id=$1$_$;


ALTER FUNCTION public.get_unit(bigint) OWNER TO postgres;


--
-- Name: get_yield_unit(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_yield_unit(bigint) RETURNS character
    LANGUAGE sql
    AS $_$SELECT yield_unit FROM yield_unit WHERE id=$1 $_$;


ALTER FUNCTION public.get_yield_unit(bigint) OWNER TO postgres;

--
-- Name: query_add_added_to_recipe(date, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_added_to_recipe(date, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set added = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_added_to_recipe(date, bigint) OWNER TO postgres;

--
-- Name: query_add_addedby_to_recipe(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_addedby_to_recipe(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set addedby = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_addedby_to_recipe(text, bigint) OWNER TO postgres;

--
-- Name: query_add_admin_recipe_comments(bigint, bigint, text, timestamp without time zone); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_admin_recipe_comments(bigint, bigint, text, timestamp without time zone) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO comments (recipe, owner, comment, date, checked) values($1,$2,$3,$4,TRUE)$_$;


ALTER FUNCTION public.query_add_admin_recipe_comments(bigint, bigint, text, timestamp without time zone) OWNER TO postgres;

--
-- Name: query_add_aisle(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_aisle(text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into aisles (aisle) VALUES ($1)$_$;


ALTER FUNCTION public.query_add_aisle(text) OWNER TO postgres;

--
-- Name: query_add_aisle_ing(bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_aisle_ing(bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into ingredient_owner (ingredient,aisle,owner) VALUES ($1,$2,$3)$_$;


ALTER FUNCTION public.query_add_aisle_ing(bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_aisle_to_ing(bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_aisle_to_ing(bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update ingredient_owner set aisle = $1, aisle_order=(select distinct aisle_order from ingredient_owner where aisle=$1 and owner=$3) where ingredient=$2 and owner = $3$_$;


ALTER FUNCTION public.query_add_aisle_to_ing(bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_category(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_category(text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into category (category) VALUES ($1)$_$;


ALTER FUNCTION public.query_add_category(text) OWNER TO postgres;

--
-- Name: query_add_cooktime_to_recipe(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_cooktime_to_recipe(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set cooktime = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_cooktime_to_recipe(text, bigint) OWNER TO postgres;

--
-- Name: query_add_cuisine(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_cuisine(text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into cuisine (cuisine) VALUES ($1)$_$;


ALTER FUNCTION public.query_add_cuisine(text) OWNER TO postgres;

--
-- Name: query_add_cuisine_to_recipe(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_cuisine_to_recipe(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set cuisine = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_cuisine_to_recipe(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_date_pref(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_date_pref(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update owner set datefmt = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_date_pref(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_diet(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_diet(text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into diet (diet) VALUES ($1)$_$;


ALTER FUNCTION public.query_add_diet(text) OWNER TO postgres;

--
-- Name: query_add_directions_to_recipe(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_directions_to_recipe(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set directions = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_directions_to_recipe(text, bigint) OWNER TO postgres;

--
-- Name: query_add_eboption_prefs(boolean, boolean, boolean, boolean, boolean, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_eboption_prefs(boolean, boolean, boolean, boolean, boolean, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update owner set toc = $1, catt= $2, welcome = $3, pdf=$4, rapp=$5 where id=$6$_$;


ALTER FUNCTION public.query_add_eboption_prefs(boolean, boolean, boolean, boolean, boolean, bigint) OWNER TO postgres;

--
-- Name: query_add_ebtitle_pref(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_ebtitle_pref(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update owner set ebtitle = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_ebtitle_pref(text, bigint) OWNER TO postgres;

--
-- Name: query_add_exclusion(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_exclusion(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO excluded_ing (ing , owner) VALUES ($1, $2)$_$;


ALTER FUNCTION public.query_add_exclusion(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_expiry(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_expiry(text) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE server set expire=$1$_$;


ALTER FUNCTION public.query_add_expiry(text) OWNER TO postgres;

--
-- Name: query_add_fav(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_fav(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into favourites (id,owner) values($1,$2)$_$;


ALTER FUNCTION public.query_add_fav(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_image(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_image(text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into image (image) values ($1)$_$;


ALTER FUNCTION public.query_add_image(text) OWNER TO postgres;

--
-- Name: query_add_image_to_recipe(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_image_to_recipe(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into recipe_image (recipe, image) values($2, get_image_id($1))$_$;


ALTER FUNCTION public.query_add_image_to_recipe(text, bigint) OWNER TO postgres;

--
-- Name: query_add_ingredient(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_ingredient(text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into ingredient (ingredient) VALUES ($1)$_$;


ALTER FUNCTION public.query_add_ingredient(text) OWNER TO postgres;

--
-- Name: query_add_list(bigint, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_list(bigint, text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO shopping_list (owner, list) VALUES ($1, $2)$_$;


ALTER FUNCTION public.query_add_list(bigint, text) OWNER TO postgres;

--
-- Name: query_add_list_entry(bigint, text, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_list_entry(bigint, text, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO shopping_list_entry (list , entry, ing, recipe) VALUES ($1, $2, $3, $4)$_$;


ALTER FUNCTION public.query_add_list_entry(bigint, text, bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_logdate_to_owner(date, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_logdate_to_owner(date, text) RETURNS void
    LANGUAGE sql
    AS $_$update owner set lastlogin = $1 where owner=$2$_$;


ALTER FUNCTION public.query_add_logdate_to_owner(date, text) OWNER TO postgres;

--
-- Name: query_add_measure(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_measure(text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into measure (measure) VALUES ($1)$_$;


ALTER FUNCTION public.query_add_measure(text) OWNER TO postgres;

--
-- Name: query_add_measure_pref(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_measure_pref(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update owner set measure = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_measure_pref(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_measure_to_recipe(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_measure_to_recipe(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set measure = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_measure_to_recipe(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_menu(bigint, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_menu(bigint, text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO menu (owner, menu) VALUES ($1, $2)$_$;


ALTER FUNCTION public.query_add_menu(bigint, text) OWNER TO postgres;

--
-- Name: query_add_menu_recipe(bigint, text, bigint, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_menu_recipe(bigint, text, bigint, integer, integer) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO menu_recipe (menu,link,recipe,day,rank) VALUES ($1, $2, $3, $4, $5)$_$;


ALTER FUNCTION public.query_add_menu_recipe(bigint, text, bigint, integer, integer) OWNER TO postgres;

--
-- Name: query_add_note_to_recipe(character, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_note_to_recipe(character, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set note = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_note_to_recipe(character, bigint) OWNER TO postgres;

--
-- Name: query_add_owner_category(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_owner_category(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into category_owner (category,owner) VALUES ($1,$2)$_$;


ALTER FUNCTION public.query_add_owner_category(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_owner_cuisine(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_owner_cuisine(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into cuisine_owner (cuisine,owner) VALUES ($1,$2)$_$;


ALTER FUNCTION public.query_add_owner_cuisine(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_owner_diet(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_owner_diet(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into diet_owner (diet,owner) VALUES ($1,$2)$_$;


ALTER FUNCTION public.query_add_owner_diet(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_owner_ingredient(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_owner_ingredient(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into ingredient_owner (ingredient,owner) VALUES ($1,$2)$_$;


ALTER FUNCTION public.query_add_owner_ingredient(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_owner_measure(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_owner_measure(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into measure_owner (measure,owner) VALUES ($1,$2)$_$;


ALTER FUNCTION public.query_add_owner_measure(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_owner_preprep(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_owner_preprep(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into preprep_owner (preprep,owner) VALUES ($1,$2)$_$;


ALTER FUNCTION public.query_add_owner_preprep(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_owner_sl_ingredient(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_owner_sl_ingredient(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into ingredient_owner (ingredient,owner,sl) VALUES ($1,$2,true)$_$;


ALTER FUNCTION public.query_add_owner_sl_ingredient(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_owner_source(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_owner_source(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into source_owner (source,owner) VALUES ($1,$2)$_$;


ALTER FUNCTION public.query_add_owner_source(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_owner_subcategory(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_owner_subcategory(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into subcategory_owner (subcategory,owner) VALUES ($1,$2)$_$;


ALTER FUNCTION public.query_add_owner_subcategory(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_owner_unit(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_owner_unit(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into unit_owner (unit,owner) VALUES ($1,$2)$_$;


ALTER FUNCTION public.query_add_owner_unit(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_owner_yield_unit(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_owner_yield_unit(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into yield_unit_owner (yield_unit,owner) VALUES ($1,$2)$_$;


ALTER FUNCTION public.query_add_owner_yield_unit(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_paper_pref(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_paper_pref(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update owner set paper = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_paper_pref(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_pdf_to_recipe(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_pdf_to_recipe(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set pdf = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_pdf_to_recipe(text, bigint) OWNER TO postgres;

--
-- Name: query_add_preprep(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_preprep(text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into preprep (preprep) VALUES ($1)$_$;


ALTER FUNCTION public.query_add_preprep(text) OWNER TO postgres;

--
-- Name: query_add_preprep1_to_ing(bigint, bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_preprep1_to_ing(bigint, bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe_ing set preprep1 = $1 where recipe=$2 and ing=$3 and id=$4$_$;


ALTER FUNCTION public.query_add_preprep1_to_ing(bigint, bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_preprep2_to_ing(bigint, bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_preprep2_to_ing(bigint, bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe_ing set preprep2 = $1 where recipe=$2 and ing=$3 and id=$4$_$;


ALTER FUNCTION public.query_add_preprep2_to_ing(bigint, bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_preptime_to_recipe(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_preptime_to_recipe(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set preptime = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_preptime_to_recipe(text, bigint) OWNER TO postgres;

--
-- Name: query_add_qtydec_to_ing(numeric, bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_qtydec_to_ing(numeric, bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe_ing set qtydec = $1 where recipe=$2 and ing=$3 and id=$4$_$;


ALTER FUNCTION public.query_add_qtydec_to_ing(numeric, bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_quantity2_to_ing(text, bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_quantity2_to_ing(text, bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe_ing set quantity2 = $1 where recipe=$2 and ing=$3 and id=$4$_$;


ALTER FUNCTION public.query_add_quantity2_to_ing(text, bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_quantity_to_ing(text, bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_quantity_to_ing(text, bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe_ing set quantity = $1 where recipe=$2 and ing=$3 and id=$4$_$;


ALTER FUNCTION public.query_add_quantity_to_ing(text, bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_rating(integer, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_rating(integer, integer, integer) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into recipe_rating (recipe, rating, rater) values($1,$2,$3)$_$;


ALTER FUNCTION public.query_add_rating(integer, integer, integer) OWNER TO postgres;

--
-- Name: query_add_rating_to_recipe(integer, integer, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_rating_to_recipe(integer, integer, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set rating = $1, total_ratings=$2 where id=$3$_$;


ALTER FUNCTION public.query_add_rating_to_recipe(integer, integer, bigint) OWNER TO postgres;

--
-- Name: query_add_recipe(bigint, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_recipe(bigint, text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO recipe (owner, name) VALUES ($1, $2)$_$;


ALTER FUNCTION public.query_add_recipe(bigint, text) OWNER TO postgres;

--
-- Name: query_add_recipe_cat(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_recipe_cat(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO recipe_cat_subcat (recipe, cat) VALUES ($1 , $2)$_$;


ALTER FUNCTION public.query_add_recipe_cat(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_recipe_cat_subcat(bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_recipe_cat_subcat(bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO recipe_cat_subcat (recipe, cat, subcat) VALUES ($1 , $2, $3)$_$;


ALTER FUNCTION public.query_add_recipe_cat_subcat(bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_recipe_comments(bigint, bigint, text, timestamp without time zone); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_recipe_comments(bigint, bigint, text, timestamp without time zone) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO comments (recipe, owner, comment, date) values($1,$2,$3,$4)$_$;


ALTER FUNCTION public.query_add_recipe_comments(bigint, bigint, text, timestamp without time zone) OWNER TO postgres;

--
-- Name: query_add_recipe_diet(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_recipe_diet(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO recipe_diet (recipe , diet) VALUES ($1, $2)$_$;


ALTER FUNCTION public.query_add_recipe_diet(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_recipe_ing(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_recipe_ing(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO recipe_ing (recipe,ing) VALUES ($1, $2)$_$;


ALTER FUNCTION public.query_add_recipe_ing(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_related_recipe(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_related_recipe(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO recipe_recipe (id,related_id) VALUES ($1,$2)$_$;


ALTER FUNCTION public.query_add_related_recipe(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_source(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_source(text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into source (source) VALUES ($1)$_$;


ALTER FUNCTION public.query_add_source(text) OWNER TO postgres;

--
-- Name: query_add_source_to_recipe(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_source_to_recipe(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set source = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_source_to_recipe(bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_subcategory(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_subcategory(text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into subcategory (subcategory) VALUES ($1)$_$;


ALTER FUNCTION public.query_add_subcategory(text) OWNER TO postgres;

--
-- Name: query_add_tried_to_recipe(boolean, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_tried_to_recipe(boolean, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set tried = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_tried_to_recipe(boolean, bigint) OWNER TO postgres;

--
-- Name: query_add_unit(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_unit(text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into unit (unit) VALUES ($1)$_$;


ALTER FUNCTION public.query_add_unit(text) OWNER TO postgres;

--
-- Name: query_add_unit2_to_ing(bigint, bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_unit2_to_ing(bigint, bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe_ing set unit2 = $1 where recipe=$2 and ing=$3 and id=$4$_$;


ALTER FUNCTION public.query_add_unit2_to_ing(bigint, bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_unit_to_ing(bigint, bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_unit_to_ing(bigint, bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe_ing set unit = $1 where recipe=$2 and ing=$3 and id=$4$_$;


ALTER FUNCTION public.query_add_unit_to_ing(bigint, bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_updated_to_recipe(date, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_updated_to_recipe(date, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set updated = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_updated_to_recipe(date, bigint) OWNER TO postgres;

--
-- Name: query_add_user(text, text, text, text, text, date); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_user(text, text, text, text, text, date) RETURNS void
    LANGUAGE sql
    AS $_$INSERT INTO owner (owner, fname, lname, password, email, regdate, approved) VALUES ($1, $2, $3, $4, $5, $6, false)$_$;


ALTER FUNCTION public.query_add_user(text, text, text, text, text, date) OWNER TO postgres;

--
-- Name: query_add_video_to_recipe(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_video_to_recipe(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set video = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_video_to_recipe(text, bigint) OWNER TO postgres;

--
-- Name: query_add_visible_to_recipe(boolean, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_visible_to_recipe(boolean, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set visible = $1, owner = $2 where id=$3$_$;


ALTER FUNCTION public.query_add_visible_to_recipe(boolean, bigint, bigint) OWNER TO postgres;

--
-- Name: query_add_yield_to_recipe(numeric, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_yield_to_recipe(numeric, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set yield = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_yield_to_recipe(numeric, bigint) OWNER TO postgres;

--
-- Name: query_add_yield_unit(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_yield_unit(text) RETURNS void
    LANGUAGE sql
    AS $_$INSERT into yield_unit (yield_unit) VALUES ($1)$_$;


ALTER FUNCTION public.query_add_yield_unit(text) OWNER TO postgres;

--
-- Name: query_add_yield_unit_to_recipe(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_add_yield_unit_to_recipe(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set yield_unit = $1 where id=$2$_$;


ALTER FUNCTION public.query_add_yield_unit_to_recipe(bigint, bigint) OWNER TO postgres;

--
-- Name: query_aisle_exists(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_aisle_exists(text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM aisles WHERE aisle = $1$_$;


ALTER FUNCTION public.query_aisle_exists(text) OWNER TO postgres;

--
-- Name: query_aisle_has_order(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_aisle_has_order(bigint, bigint) RETURNS bigint
    LANGUAGE sql
    AS $_$SELECT DISTINCT aisle_order FROM ingredient_owner WHERE aisle=$1 and owner=$2$_$;


ALTER FUNCTION public.query_aisle_has_order(bigint, bigint) OWNER TO postgres;

--
-- Name: query_aisle_id(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_aisle_id(text) RETURNS bigint
    LANGUAGE sql
    AS $_$select id from aisles where aisle=$1$_$;


ALTER FUNCTION public.query_aisle_id(text) OWNER TO postgres;

--
-- Name: query_aisle_used_by_others(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_aisle_used_by_others(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id from ingredient_owner where aisle = $1 and owner != $2$_$;


ALTER FUNCTION public.query_aisle_used_by_others(bigint, bigint) OWNER TO postgres;

--
-- Name: query_all_categorys(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_all_categorys(OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT category, id FROM category where id != 20 ORDER BY category$$;


ALTER FUNCTION public.query_all_categorys(OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_all_ingredients(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_all_ingredients(bigint, OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT ingredient, id FROM ingredient where id in(select ingredient from ingredient_owner where owner = $1) ORDER BY ingredient$_$;


ALTER FUNCTION public.query_all_ingredients(bigint, OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_all_pp(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_all_pp(bigint, OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT preprep, id FROM preprep where id in(select preprep from preprep_owner where owner = $1) ORDER BY preprep$_$;


ALTER FUNCTION public.query_all_pp(bigint, OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_all_subcategorys(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_all_subcategorys(OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT subcategory, id FROM subcategory where id != 32 ORDER BY subcategory$$;


ALTER FUNCTION public.query_all_subcategorys(OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_all_units(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_all_units(bigint, OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT unit, id FROM unit where id in(select unit from unit_owner where owner = $1) ORDER BY unit$_$;


ALTER FUNCTION public.query_all_units(bigint, OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_all_yield_units(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_all_yield_units(bigint, OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT yield_unit, id FROM yield_unit where id in(select yield_unit from yield_unit_owner where owner = $1) ORDER BY yield_unit$_$;


ALTER FUNCTION public.query_all_yield_units(bigint, OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_approve(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_approve(bigint) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE recipe set approved=true where id=$1$_$;


ALTER FUNCTION public.query_approve(bigint) OWNER TO postgres;

--
-- Name: query_approve_user(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_approve_user(text) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE owner SET approved=true WHERE owner = $1$_$;


ALTER FUNCTION public.query_approve_user(text) OWNER TO postgres;

--
-- Name: query_cat_name(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_cat_name(bigint) RETURNS SETOF text
    LANGUAGE sql
    AS $_$SELECT category FROM category WHERE id = $1$_$;


ALTER FUNCTION public.query_cat_name(bigint) OWNER TO postgres;

--
-- Name: query_category_exists(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_category_exists(text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM category WHERE category = $1$_$;


ALTER FUNCTION public.query_category_exists(text) OWNER TO postgres;

--
-- Name: query_category_or_categorys_exists(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_category_or_categorys_exists(text, text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM category WHERE upper(category) = upper($1) or upper(category) = upper($2)$_$;


ALTER FUNCTION public.query_category_or_categorys_exists(text, text) OWNER TO postgres;

--
-- Name: query_category_owner_exists(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_category_owner_exists(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM category_owner WHERE category = $1 and owner=$2$_$;


ALTER FUNCTION public.query_category_owner_exists(bigint, bigint) OWNER TO postgres;

--
-- Name: query_cats(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_cats() RETURNS SETOF text
    LANGUAGE sql
    AS $$SELECT category FROM category where id != 20 order by category$$;


ALTER FUNCTION public.query_cats() OWNER TO postgres;

--
-- Name: query_check_if_fav(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_check_if_fav(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$Select id from favourites where id=$1 and owner=$2$_$;


ALTER FUNCTION public.query_check_if_fav(bigint, bigint) OWNER TO postgres;

--
-- Name: query_chk_image_used_elsewhere(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_chk_image_used_elsewhere(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$select image from recipe_image where image=$1 and not recipe=$2$_$;


ALTER FUNCTION public.query_chk_image_used_elsewhere(bigint, bigint) OWNER TO postgres;

--
-- Name: query_chk_ing_used_elsewhere(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_chk_ing_used_elsewhere(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$select id from ingredient_owner where ingredient=$1 and owner!=$2$_$;


ALTER FUNCTION public.query_chk_ing_used_elsewhere(bigint, bigint) OWNER TO postgres;

--
-- Name: query_chk_pdf_used_elsewhere(character, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_chk_pdf_used_elsewhere(character, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$select id from recipe where pdf=$1 and not id=$2$_$;


ALTER FUNCTION public.query_chk_pdf_used_elsewhere(character, bigint) OWNER TO postgres;

--
-- Name: query_chk_pp_used_elsewhere(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_chk_pp_used_elsewhere(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$select id from preprep_owner where preprep=$1 and owner!=$2$_$;


ALTER FUNCTION public.query_chk_pp_used_elsewhere(bigint, bigint) OWNER TO postgres;

--
-- Name: query_chk_unit_used_elsewhere(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_chk_unit_used_elsewhere(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$select id from unit_owner where unit=$1 and owner!=$2$_$;


ALTER FUNCTION public.query_chk_unit_used_elsewhere(bigint, bigint) OWNER TO postgres;

--
-- Name: query_chk_video_used_elsewhere(character, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_chk_video_used_elsewhere(character, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$select id from recipe where video=$1 and not id=$2$_$;


ALTER FUNCTION public.query_chk_video_used_elsewhere(character, bigint) OWNER TO postgres;

--
-- Name: query_chk_yield_unit_used_elsewhere(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_chk_yield_unit_used_elsewhere(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$select id from yield_unit_owner where yield_unit=$1 and owner!=$2$_$;


ALTER FUNCTION public.query_chk_yield_unit_used_elsewhere(bigint, bigint) OWNER TO postgres;

--
-- Name: query_clear_recipe_combos(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_clear_recipe_combos(bigint) RETURNS void
    LANGUAGE sql
    AS $_$delete from recipe_diet where recipe=$1;

delete from recipe_recipe where id=$1;

delete from recipe_cat_subcat where recipe=$1;

delete from recipe_ing where recipe=$1;$_$;


ALTER FUNCTION public.query_clear_recipe_combos(bigint) OWNER TO postgres;

--
-- Name: query_comment_checked(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_comment_checked(bigint) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE comments SET checked=true where commentid=$1$_$;


ALTER FUNCTION public.query_comment_checked(bigint) OWNER TO postgres;

--
-- Name: query_comments(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_comments(OUT bigint, OUT text, OUT timestamp without time zone, OUT character, OUT character) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT commentid, comment, date, get_owner(owner) as owner, get_recipename(recipe) as recipename FROM comments WHERE checked is not true ORDER BY date desc$$;


ALTER FUNCTION public.query_comments(OUT bigint, OUT text, OUT timestamp without time zone, OUT character, OUT character) OWNER TO postgres;

--
-- Name: query_cuisine_exists(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_cuisine_exists(text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM cuisine WHERE cuisine = $1$_$;


ALTER FUNCTION public.query_cuisine_exists(text) OWNER TO postgres;

--
-- Name: query_cuisine_or_cuisines_exists(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_cuisine_or_cuisines_exists(text, text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM cuisine WHERE upper(cuisine) = upper($1) or upper(cuisine) = upper($2)$_$;


ALTER FUNCTION public.query_cuisine_or_cuisines_exists(text, text) OWNER TO postgres;

--
-- Name: query_cuisine_owner_exists(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_cuisine_owner_exists(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM cuisine_owner WHERE cuisine = $1 and owner=$2$_$;


ALTER FUNCTION public.query_cuisine_owner_exists(bigint, bigint) OWNER TO postgres;

--
-- Name: query_cuisines(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_cuisines(OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT cuisine, id FROM cuisine WHERE id IN (SELECT DISTINCT cuisine FROM recipe) ORDER BY cuisine$$;


ALTER FUNCTION public.query_cuisines(OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_del_rating(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_del_rating(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE from recipe_rating WHERE recipe=$1 and rater = $2$_$;


ALTER FUNCTION public.query_del_rating(bigint, bigint) OWNER TO postgres;

--
-- Name: query_delete_aisle(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_aisle(text) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM aisles WHERE aisle=$1$_$;


ALTER FUNCTION public.query_delete_aisle(text) OWNER TO postgres;

--
-- Name: query_delete_cat(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_cat(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM category WHERE id=$1$_$;


ALTER FUNCTION public.query_delete_cat(bigint) OWNER TO postgres;

--
-- Name: query_delete_comment(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_comment(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE from comments WHERE commentid=$1$_$;


ALTER FUNCTION public.query_delete_comment(bigint) OWNER TO postgres;

--
-- Name: query_delete_exclusions(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_exclusions(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM excluded_ing WHERE owner=$1$_$;


ALTER FUNCTION public.query_delete_exclusions(bigint) OWNER TO postgres;

--
-- Name: query_delete_fav(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_fav(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM favourites WHERE id=$1 and owner=$2$_$;


ALTER FUNCTION public.query_delete_fav(bigint, bigint) OWNER TO postgres;

--
-- Name: query_delete_image(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_image(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM image WHERE id=$1$_$;


ALTER FUNCTION public.query_delete_image(bigint) OWNER TO postgres;

--
-- Name: query_delete_ing(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_ing(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM ingredient WHERE id=$1$_$;


ALTER FUNCTION public.query_delete_ing(bigint) OWNER TO postgres;

--
-- Name: query_delete_list(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_list(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM shopping_list WHERE id=$1$_$;


ALTER FUNCTION public.query_delete_list(bigint) OWNER TO postgres;

--
-- Name: query_delete_menu(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_menu(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM menu WHERE id=$1$_$;


ALTER FUNCTION public.query_delete_menu(bigint) OWNER TO postgres;

--
-- Name: query_delete_owner_ing(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_owner_ing(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM ingredient_owner WHERE ingredient=$1 and owner=$2$_$;


ALTER FUNCTION public.query_delete_owner_ing(bigint, bigint) OWNER TO postgres;

--
-- Name: query_delete_owner_pp(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_owner_pp(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM preprep_owner WHERE preprep=$1 and owner=$2$_$;


ALTER FUNCTION public.query_delete_owner_pp(bigint, bigint) OWNER TO postgres;

--
-- Name: query_delete_owner_unit(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_owner_unit(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM unit_owner WHERE unit=$1 and owner=$2$_$;


ALTER FUNCTION public.query_delete_owner_unit(bigint, bigint) OWNER TO postgres;

--
-- Name: query_delete_owner_yield_unit(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_owner_yield_unit(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM yield_unit_owner WHERE yield_unit=$1 and owner=$2$_$;


ALTER FUNCTION public.query_delete_owner_yield_unit(bigint, bigint) OWNER TO postgres;

--
-- Name: query_delete_pp(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_pp(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM preprep WHERE id=$1$_$;


ALTER FUNCTION public.query_delete_pp(bigint) OWNER TO postgres;

--
-- Name: query_delete_recipe(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_recipe(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM recipe WHERE id=$1$_$;


ALTER FUNCTION public.query_delete_recipe(bigint) OWNER TO postgres;

--
-- Name: query_delete_recipe_comments(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_recipe_comments(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE from comments WHERE recipe=$1$_$;


ALTER FUNCTION public.query_delete_recipe_comments(bigint) OWNER TO postgres;

--
-- Name: query_delete_recipe_image(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_recipe_image(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE from recipe_image WHERE recipe=$1 and image=$2$_$;


ALTER FUNCTION public.query_delete_recipe_image(bigint, bigint) OWNER TO postgres;

--
-- Name: query_delete_recipe_images(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_recipe_images(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE from recipe_image WHERE recipe=$1$_$;


ALTER FUNCTION public.query_delete_recipe_images(bigint) OWNER TO postgres;

--
-- Name: query_delete_recipe_pdf(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_recipe_pdf(bigint) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE recipe SET pdf=NULL WHERE id=$1$_$;


ALTER FUNCTION public.query_delete_recipe_pdf(bigint) OWNER TO postgres;

--
-- Name: query_delete_recipe_video(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_recipe_video(bigint) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE recipe SET video=NULL WHERE id=$1$_$;


ALTER FUNCTION public.query_delete_recipe_video(bigint) OWNER TO postgres;

--
-- Name: query_delete_subcat(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_subcat(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM subcategory WHERE id=$1$_$;


ALTER FUNCTION public.query_delete_subcat(bigint) OWNER TO postgres;

--
-- Name: query_delete_unit(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_unit(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM unit WHERE id=$1$_$;


ALTER FUNCTION public.query_delete_unit(bigint) OWNER TO postgres;

--
-- Name: query_delete_user(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_user(text) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM owner WHERE owner=$1$_$;


ALTER FUNCTION public.query_delete_user(text) OWNER TO postgres;

--
-- Name: query_delete_yield_unit(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_delete_yield_unit(bigint) RETURNS void
    LANGUAGE sql
    AS $_$DELETE FROM yield_unit WHERE id=$1$_$;


ALTER FUNCTION public.query_delete_yield_unit(bigint) OWNER TO postgres;

--
-- Name: query_diet_exists(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_diet_exists(text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM diet WHERE diet = $1$_$;


ALTER FUNCTION public.query_diet_exists(text) OWNER TO postgres;

--
-- Name: query_diet_or_diets_exists(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_diet_or_diets_exists(text, text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM diet WHERE upper(diet) = upper($1) or upper(diet) = upper($2)$_$;


ALTER FUNCTION public.query_diet_or_diets_exists(text, text) OWNER TO postgres;

--
-- Name: query_diet_owner_exists(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_diet_owner_exists(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM diet_owner WHERE diet = $1 and owner=$2$_$;


ALTER FUNCTION public.query_diet_owner_exists(bigint, bigint) OWNER TO postgres;

--
-- Name: query_diets(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_diets(OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT diet, id FROM diet where id in(select DISTINCT diet from recipe_diet where recipe in(select distinct id from recipe)) ORDER BY diet$$;


ALTER FUNCTION public.query_diets(OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_email_in_use(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_email_in_use(text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM owner WHERE email = $1$_$;


ALTER FUNCTION public.query_email_in_use(text) OWNER TO postgres;

--
-- Name: query_email_user(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_email_user(text) RETURNS SETOF text
    LANGUAGE sql
    AS $_$SELECT email FROM owner WHERE owner = $1$_$;


ALTER FUNCTION public.query_email_user(text) OWNER TO postgres;

--
-- Name: query_expiry(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_expiry(OUT text) RETURNS SETOF text
    LANGUAGE sql
    AS $$SELECT DISTINCT expire FROM server$$;


ALTER FUNCTION public.query_expiry(OUT text) OWNER TO postgres;

--
-- Name: query_hide_recipe(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_hide_recipe(bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set visible = false where id=$1$_$;


ALTER FUNCTION public.query_hide_recipe(bigint) OWNER TO postgres;

--
-- Name: query_image_exists(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_image_exists(text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM image WHERE image = $1$_$;


ALTER FUNCTION public.query_image_exists(text) OWNER TO postgres;

--
-- Name: query_ingredient_exists(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_ingredient_exists(text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM ingredient WHERE ingredient = $1$_$;


ALTER FUNCTION public.query_ingredient_exists(text) OWNER TO postgres;

--
-- Name: query_ingredient_name(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_ingredient_name(bigint) RETURNS SETOF text
    LANGUAGE sql
    AS $_$SELECT ingredient FROM ingredient WHERE id = $1$_$;


ALTER FUNCTION public.query_ingredient_name(bigint) OWNER TO postgres;

--
-- Name: query_ingredient_owner_exists(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_ingredient_owner_exists(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM ingredient_owner WHERE ingredient = $1 and owner=$2$_$;


ALTER FUNCTION public.query_ingredient_owner_exists(bigint, bigint) OWNER TO postgres;

--
-- Name: query_latest_recipe(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_latest_recipe(OUT id bigint, OUT date) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT id, greatest(added,updated) as date FROM recipe WHERE visible is TRUE and approved is TRUE order by date DESC LIMIT 1$$;


ALTER FUNCTION public.query_latest_recipe(OUT id bigint, OUT date) OWNER TO postgres;

--
-- Name: query_latest_recipe_ing(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_latest_recipe_ing(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT greatest(id) as id FROM recipe_ing WHERE recipe=$1 and ing=$2 order by id DESC LIMIT 1$_$;


ALTER FUNCTION public.query_latest_recipe_ing(bigint, bigint) OWNER TO postgres;

--
-- Name: query_latest_unapproved(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_latest_unapproved(OUT id bigint, OUT date) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT id, greatest(added,updated) as date FROM recipe where approved is not true order by date DESC LIMIT 1$$;


ALTER FUNCTION public.query_latest_unapproved(OUT id bigint, OUT date) OWNER TO postgres;

--
-- Name: query_list(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_list(bigint, bigint, OUT text, OUT character, OUT character, OUT bigint, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT entry, get_ingredient(ing) as ing, get_ing_aisle(ing,$2)as aisle, recipe, get_ing_aisle_order(ing,$2) as aisle_order FROM shopping_list_entry where list=$1 order by aisle_order,aisle, ing$_$;


ALTER FUNCTION public.query_list(bigint, bigint, OUT text, OUT character, OUT character, OUT bigint, OUT bigint) OWNER TO postgres;

--
-- Name: query_measure_exists(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_measure_exists(text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM measure WHERE measure = $1$_$;


ALTER FUNCTION public.query_measure_exists(text) OWNER TO postgres;

--
-- Name: query_measure_owner_exists(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_measure_owner_exists(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM measure_owner WHERE measure = $1 and owner=$2$_$;


ALTER FUNCTION public.query_measure_owner_exists(bigint, bigint) OWNER TO postgres;

--
-- Name: query_measures(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_measures(OUT bigint, OUT text) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT id, measure from measure ORDER BY measure$$;


ALTER FUNCTION public.query_measures(OUT bigint, OUT text) OWNER TO postgres;

--
-- Name: query_menu(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_menu(bigint, OUT text, OUT bigint, OUT smallint, OUT smallint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT link, recipe, day, rank FROM menu_recipe where menu=$1 ORDER BY day, rank$_$;


ALTER FUNCTION public.query_menu(bigint, OUT text, OUT bigint, OUT smallint, OUT smallint) OWNER TO postgres;

--
-- Name: query_menu_exists(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_menu_exists(text, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM menu where menu=$1 and owner= $2$_$;


ALTER FUNCTION public.query_menu_exists(text, bigint) OWNER TO postgres;

--
-- Name: query_new_list_id(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_new_list_id(text, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM shopping_list WHERE list = $1 and owner=$2$_$;


ALTER FUNCTION public.query_new_list_id(text, bigint) OWNER TO postgres;

--
-- Name: query_new_menu_id(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_new_menu_id(text, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM menu WHERE menu = $1 and owner=$2$_$;


ALTER FUNCTION public.query_new_menu_id(text, bigint) OWNER TO postgres;

--
-- Name: query_new_recipe_id(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_new_recipe_id(text, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT max(id) FROM recipe WHERE name = $1 and owner=$2$_$;


ALTER FUNCTION public.query_new_recipe_id(text, bigint) OWNER TO postgres;

--
-- Name: query_owner(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner(bigint, OUT text, OUT text, OUT text) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT email, fname, lname from owner where id=$1$_$;


ALTER FUNCTION public.query_owner(bigint, OUT text, OUT text, OUT text) OWNER TO postgres;

--
-- Name: query_owner_aisle_list(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_aisle_list(bigint, OUT bigint, OUT character) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT DISTINCT aisle as id, get_aisle(aisle) as aisle FROM ingredient_owner where owner=$1 and aisle is not null ORDER BY aisle$_$;


ALTER FUNCTION public.query_owner_aisle_list(bigint, OUT bigint, OUT character) OWNER TO postgres;

--
-- Name: query_owner_aisles(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_aisles(bigint, OUT bigint, OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT DISTINCT aisle as id, get_aisle(aisle) as aisle, aisle_order FROM ingredient_owner where owner=$1 and aisle is not null ORDER BY aisle_order, aisle$_$;


ALTER FUNCTION public.query_owner_aisles(bigint, OUT bigint, OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_owner_cuisines(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_cuisines(bigint, OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT get_cuisine(cuisine) as cuisine, cuisine as id FROM cuisine_owner WHERE owner = $1 ORDER BY cuisine$_$;


ALTER FUNCTION public.query_owner_cuisines(bigint, OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_owner_diets(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_diets(bigint, OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT get_diet(diet) as diet, diet as id FROM diet_owner where owner=$1 ORDER BY diet$_$;


ALTER FUNCTION public.query_owner_diets(bigint, OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_owner_excl_ingredients(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_excl_ingredients(bigint, OUT bigint, OUT character) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT ing, get_ingredient(ing) as ingredient FROM excluded_ing where owner=$1 ORDER BY ingredient$_$;


ALTER FUNCTION public.query_owner_excl_ingredients(bigint, OUT bigint, OUT character) OWNER TO postgres;

--
-- Name: query_owner_favourites(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_favourites(bigint, OUT bigint, OUT character) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT id, get_recipename(id) as name FROM favourites where owner =$1 order by name$_$;


ALTER FUNCTION public.query_owner_favourites(bigint, OUT bigint, OUT character) OWNER TO postgres;

--
-- Name: query_owner_ids(character); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_ids(character) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id from owner where owner=$1$_$;


ALTER FUNCTION public.query_owner_ids(character) OWNER TO postgres;

--
-- Name: query_owner_ingredients(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_ingredients(bigint) RETURNS SETOF character
    LANGUAGE sql
    AS $_$SELECT get_ingredient(ingredient) as ingredient FROM ingredient_owner where owner=$1 ORDER BY ingredient$_$;


ALTER FUNCTION public.query_owner_ingredients(bigint) OWNER TO postgres;

--
-- Name: query_owner_ingredients_ids(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_ingredients_ids(bigint, OUT bigint, OUT character) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT id, ingredient FROM ingredient where id in(SELECT distinct ing FROM recipe_ing where get_recipe_owner(recipe)=$1) ORDER BY ingredient$_$;


ALTER FUNCTION public.query_owner_ingredients_ids(bigint, OUT bigint, OUT character) OWNER TO postgres;

--
-- Name: query_owner_is_admin(character); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_is_admin(character) RETURNS SETOF boolean
    LANGUAGE sql
    AS $_$SELECT admin from owner where owner=$1 and admin is true$_$;


ALTER FUNCTION public.query_owner_is_admin(character) OWNER TO postgres;

--
-- Name: query_owner_lists(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_lists(bigint, OUT bigint, OUT text) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT id, list FROM shopping_list where owner=$1 ORDER BY list$_$;


ALTER FUNCTION public.query_owner_lists(bigint, OUT bigint, OUT text) OWNER TO postgres;

--
-- Name: query_owner_measures(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_measures(bigint) RETURNS SETOF character
    LANGUAGE sql
    AS $_$SELECT get_measure(measure) as measure FROM measure_owner where owner=$1 ORDER BY measure$_$;


ALTER FUNCTION public.query_owner_measures(bigint) OWNER TO postgres;

--
-- Name: query_owner_menu_cats(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_menu_cats(OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT DISTINCT get_category(cat) as category, cat FROM recipe_cat_subcat where recipe in(SELECT id FROM recipe where visible is TRUE and approved is TRUE) ORDER BY category$$;


ALTER FUNCTION public.query_owner_menu_cats(OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_owner_menu_recipes(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_menu_recipes(bigint, bigint, OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT DISTINCT get_recipename(recipe) as recipename, recipe FROM recipe_cat_subcat 

                            WHERE cat = $1 AND subcat = $2 and recipe in(SELECT id FROM recipe where visible is TRUE and approved is TRUE) ORDER BY recipename$_$;


ALTER FUNCTION public.query_owner_menu_recipes(bigint, bigint, OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_owner_menu_recipes_no_subcats(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_menu_recipes_no_subcats(bigint, OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT DISTINCT get_recipename(recipe) as recipename, recipe FROM recipe_cat_subcat 

                WHERE cat = $1 AND subcat is null and recipe in(SELECT id FROM recipe where visible is TRUE and approved is TRUE) ORDER BY recipename$_$;


ALTER FUNCTION public.query_owner_menu_recipes_no_subcats(bigint, OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_owner_menu_subcats(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_menu_subcats(bigint, OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT DISTINCT get_subcategory(subcat) as subcategory , subcat FROM recipe_cat_subcat 

                WHERE cat = $1 and subcat > 0 and recipe in(SELECT id FROM recipe where visible is TRUE and approved is TRUE) ORDER BY subcategory$_$;


ALTER FUNCTION public.query_owner_menu_subcats(bigint, OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_owner_menus(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_menus(bigint, OUT bigint, OUT text) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT id, menu FROM menu where owner=$1 ORDER BY menu$_$;


ALTER FUNCTION public.query_owner_menus(bigint, OUT bigint, OUT text) OWNER TO postgres;

--
-- Name: query_owner_nexcl_ingredients_ids_no_hdr(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_nexcl_ingredients_ids_no_hdr(bigint, OUT bigint, OUT character) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT id, ingredient FROM ingredient where id in(SELECT distinct ing FROM recipe_ing where get_recipe_owner(recipe)=$1) and id not in(select ing from excluded_ing where owner=$1) and upper(ingredient) != ingredient ORDER BY ingredient$_$;


ALTER FUNCTION public.query_owner_nexcl_ingredients_ids_no_hdr(bigint, OUT bigint, OUT character) OWNER TO postgres;

--
-- Name: query_owner_prefs(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_prefs(OUT boolean) RETURNS SETOF boolean
    LANGUAGE sql
    AS $$select rapp from owner where admin is true and rapp is true$$;


ALTER FUNCTION public.query_owner_prefs(OUT boolean) OWNER TO postgres;

--
-- Name: query_owner_prepreps(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_prepreps(bigint) RETURNS SETOF character
    LANGUAGE sql
    AS $_$SELECT get_preprep(preprep) as preprep FROM preprep_owner where owner=$1 ORDER BY preprep$_$;


ALTER FUNCTION public.query_owner_prepreps(bigint) OWNER TO postgres;

--
-- Name: query_owner_recipes_with_name(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_recipes_with_name(text, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM recipe where name ILIKE $1 and owner=$2$_$;


ALTER FUNCTION public.query_owner_recipes_with_name(text, bigint) OWNER TO postgres;

--
-- Name: query_owner_recipes_with_name_id(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_recipes_with_name_id(OUT bigint, OUT text) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT id, name FROM recipe ORDER BY name$$;


ALTER FUNCTION public.query_owner_recipes_with_name_id(OUT bigint, OUT text) OWNER TO postgres;

--
-- Name: query_owner_slitems_ids_aisles(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_slitems_ids_aisles(bigint, OUT bigint, OUT character, OUT character) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT id, ingredient, get_ing_aisle(id,$1) FROM ingredient where id in (SELECT ingredient from  ingredient_owner where sl is true and owner=$1) ORDER BY ingredient$_$;


ALTER FUNCTION public.query_owner_slitems_ids_aisles(bigint, OUT bigint, OUT character, OUT character) OWNER TO postgres;

--
-- Name: query_owner_sources(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_sources(bigint) RETURNS SETOF character
    LANGUAGE sql
    AS $_$SELECT get_source(source) as source FROM source_owner where owner=$1 ORDER BY source$_$;


ALTER FUNCTION public.query_owner_sources(bigint) OWNER TO postgres;

--
-- Name: query_owner_units(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_units(bigint) RETURNS SETOF character
    LANGUAGE sql
    AS $_$SELECT get_unit(unit) as unit FROM unit_owner WHERE owner=$1 ORDER BY unit$_$;


ALTER FUNCTION public.query_owner_units(bigint) OWNER TO postgres;

--
-- Name: query_owner_yield_units(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_owner_yield_units(bigint) RETURNS SETOF character
    LANGUAGE sql
    AS $_$SELECT get_yield_unit(yield_unit) as yield_unit FROM yield_unit_owner where owner=$1 ORDER BY yield_unit$_$;


ALTER FUNCTION public.query_owner_yield_units(bigint) OWNER TO postgres;

--
-- Name: query_pp_name(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_pp_name(bigint) RETURNS SETOF text
    LANGUAGE sql
    AS $_$SELECT preprep FROM preprep WHERE id = $1$_$;


ALTER FUNCTION public.query_pp_name(bigint) OWNER TO postgres;

--
-- Name: query_preprep_exists(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_preprep_exists(text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM preprep WHERE preprep = $1$_$;


ALTER FUNCTION public.query_preprep_exists(text) OWNER TO postgres;

--
-- Name: query_preprep_owner_exists(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_preprep_owner_exists(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM preprep_owner WHERE preprep = $1 and owner=$2$_$;


ALTER FUNCTION public.query_preprep_owner_exists(bigint, bigint) OWNER TO postgres;

--
-- Name: query_rating(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_rating(bigint, OUT bigint, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$select sum(rating) as total_rating, count(rater) as total_ratings from

		recipe_rating where recipe =$1 group by recipe$_$;


ALTER FUNCTION public.query_rating(bigint, OUT bigint, OUT bigint) OWNER TO postgres;

--
-- Name: query_recipe(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe(bigint, OUT text, OUT character varying, OUT character varying, OUT character, OUT character, OUT smallint, OUT date, OUT numeric, OUT boolean, OUT text, OUT character, OUT character, OUT date, OUT bigint, OUT text, OUT text, OUT text, OUT text) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT name, directions, note, get_source(source) as source, get_cuisine(cuisine) as cuisine, 

rating, updated, yield, tried, preptime, get_yield_unit(yield_unit) as yield_unit, 

                            get_measure(measure) as measure, added, total_ratings, pdf, addedby, cooktime, video FROM recipe WHERE id=$1$_$;


ALTER FUNCTION public.query_recipe(bigint, OUT text, OUT character varying, OUT character varying, OUT character, OUT character, OUT smallint, OUT date, OUT numeric, OUT boolean, OUT text, OUT character, OUT character, OUT date, OUT bigint, OUT text, OUT text, OUT text, OUT text) OWNER TO postgres;

--
-- Name: query_recipe_cats(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe_cats(bigint, OUT character, OUT character) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT get_category(cat) as category, get_subcategory(subcat) as subcategory FROM recipe_cat_subcat WHERE recipe = $1$_$;


ALTER FUNCTION public.query_recipe_cats(bigint, OUT character, OUT character) OWNER TO postgres;

--
-- Name: query_recipe_comments(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe_comments(bigint, OUT bigint, OUT text, OUT timestamp without time zone, OUT character) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT commentid, comment, date, get_owner(owner) as owner FROM comments WHERE recipe=$1 ORDER BY date desc$_$;


ALTER FUNCTION public.query_recipe_comments(bigint, OUT bigint, OUT text, OUT timestamp without time zone, OUT character) OWNER TO postgres;

--
-- Name: query_recipe_diets(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe_diets(bigint) RETURNS SETOF character
    LANGUAGE sql
    AS $_$SELECT get_diet(diet) as diet from recipe_diet WHERE recipe = $1$_$;


ALTER FUNCTION public.query_recipe_diets(bigint) OWNER TO postgres;

--
-- Name: query_recipe_images(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe_images(bigint, OUT bigint, OUT character) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT image as id, get_image(image) as image from recipe_image WHERE recipe = $1$_$;


ALTER FUNCTION public.query_recipe_images(bigint, OUT bigint, OUT character) OWNER TO postgres;

--
-- Name: query_recipe_ings(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe_ings(bigint, OUT text, OUT character, OUT character, OUT character, OUT character, OUT text, OUT character, OUT numeric) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT quantity, get_unit(unit) as unit, get_ingredient(ing) as ingredient, 

  get_preprep(preprep1) as preprep1, get_preprep(preprep2) as preprep2, quantity2, get_unit(unit2) as unit2, qtydec FROM recipe_ing WHERE recipe = $1 

								order by id$_$;


ALTER FUNCTION public.query_recipe_ings(bigint, OUT text, OUT character, OUT character, OUT character, OUT character, OUT text, OUT character, OUT numeric) OWNER TO postgres;

--
-- Name: query_recipe_ings_export(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe_ings_export(bigint, OUT text, OUT character, OUT text, OUT character, OUT character, OUT character, OUT character) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT quantity, get_unit(unit) as unit, quantity2, get_unit(unit2) as unit2, get_ingredient(ing) as ingredient, 

  get_preprep(preprep1) as preprep1, get_preprep(preprep2) as preprep2 FROM recipe_ing WHERE recipe = $1 

								order by id$_$;


ALTER FUNCTION public.query_recipe_ings_export(bigint, OUT text, OUT character, OUT text, OUT character, OUT character, OUT character, OUT character) OWNER TO postgres;

--
-- Name: query_recipe_name(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe_name(bigint) RETURNS SETOF text
    LANGUAGE sql
    AS $_$SELECT name FROM recipe WHERE id = $1$_$;


ALTER FUNCTION public.query_recipe_name(bigint) OWNER TO postgres;

--
-- Name: query_recipe_names(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe_names(bigint) RETURNS SETOF character
    LANGUAGE sql
    AS $_$SELECT DISTINCT name FROM recipe where owner=$1 ORDER BY name$_$;


ALTER FUNCTION public.query_recipe_names(bigint) OWNER TO postgres;

--
-- Name: query_recipe_number(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe_number(OUT bigint, OUT boolean) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT id, approved FROM recipe where visible is true$$;


ALTER FUNCTION public.query_recipe_number(OUT bigint, OUT boolean) OWNER TO postgres;

--
-- Name: query_recipe_owner(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe_owner(bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$select owner from recipe where id=$1$_$;


ALTER FUNCTION public.query_recipe_owner(bigint) OWNER TO postgres;

--
-- Name: query_recipe_pdf(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe_pdf(bigint) RETURNS SETOF character
    LANGUAGE sql
    AS $_$select pdf from recipe where id=$1 and pdf is not null$_$;


ALTER FUNCTION public.query_recipe_pdf(bigint) OWNER TO postgres;

--
-- Name: query_recipe_ratings(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe_ratings(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM recipe_rating WHERE recipe=$1 and rater =$2$_$;


ALTER FUNCTION public.query_recipe_ratings(bigint, bigint) OWNER TO postgres;

--
-- Name: query_recipe_video(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipe_video(bigint) RETURNS SETOF character
    LANGUAGE sql
    AS $_$select video from recipe where id=$1 and video is not null$_$;


ALTER FUNCTION public.query_recipe_video(bigint) OWNER TO postgres;

--
-- Name: query_recipes_with_name_id(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipes_with_name_id(bigint, OUT bigint, OUT text) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT id, name FROM recipe where owner=$1 ORDER BY name$_$;


ALTER FUNCTION public.query_recipes_with_name_id(bigint, OUT bigint, OUT text) OWNER TO postgres;

--
-- Name: query_recipes_with_name_id_owner(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipes_with_name_id_owner(OUT bigint, OUT text, OUT character) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT id, name, get_owner(owner) as owner FROM recipe ORDER BY name$$;


ALTER FUNCTION public.query_recipes_with_name_id_owner(OUT bigint, OUT text, OUT character) OWNER TO postgres;

--
-- Name: query_recipes_with_name_id_owner_visible(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_recipes_with_name_id_owner_visible(OUT bigint, OUT text, OUT character, OUT boolean) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT id, name, get_owner(owner) as owner, visible FROM recipe WHERE visible is false ORDER BY name$$;


ALTER FUNCTION public.query_recipes_with_name_id_owner_visible(OUT bigint, OUT text, OUT character, OUT boolean) OWNER TO postgres;

--
-- Name: query_related_recipes(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_related_recipes(bigint, OUT bigint, OUT bigint, OUT character, OUT character) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT id, related_id, get_recipename(id) as name, get_recipename(related_id) as relname from recipe_recipe WHERE id = $1$_$;


ALTER FUNCTION public.query_related_recipes(bigint, OUT bigint, OUT bigint, OUT character, OUT character) OWNER TO postgres;

--
-- Name: query_remove_aisle_from_ing(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_remove_aisle_from_ing(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update ingredient_owner set aisle = NULL, aisle_order = NULL where aisle=$1 and owner = $2$_$;


ALTER FUNCTION public.query_remove_aisle_from_ing(bigint, bigint) OWNER TO postgres;

--
-- Name: query_reset_user_pass(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_reset_user_pass(text, text) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE owner SET password=$1 WHERE owner = $2$_$;


ALTER FUNCTION public.query_reset_user_pass(text, text) OWNER TO postgres;

--
-- Name: query_source_exists(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_source_exists(text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM source WHERE source = $1$_$;


ALTER FUNCTION public.query_source_exists(text) OWNER TO postgres;

--
-- Name: query_source_owner_exists(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_source_owner_exists(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM source_owner WHERE source = $1 and owner=$2$_$;


ALTER FUNCTION public.query_source_owner_exists(bigint, bigint) OWNER TO postgres;

--
-- Name: query_subcat_name(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_subcat_name(bigint) RETURNS SETOF text
    LANGUAGE sql
    AS $_$SELECT subcategory FROM subcategory WHERE id = $1$_$;


ALTER FUNCTION public.query_subcat_name(bigint) OWNER TO postgres;

--
-- Name: query_subcategory_exists(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_subcategory_exists(text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM subcategory WHERE subcategory = $1$_$;


ALTER FUNCTION public.query_subcategory_exists(text) OWNER TO postgres;

--
-- Name: query_subcategory_or_subcategorys_exists(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_subcategory_or_subcategorys_exists(text, text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM subcategory WHERE upper(subcategory) = upper($1) or upper(subcategory) = upper($2)$_$;


ALTER FUNCTION public.query_subcategory_or_subcategorys_exists(text, text) OWNER TO postgres;

--
-- Name: query_subcategory_owner_exists(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_subcategory_owner_exists(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM subcategory_owner WHERE subcategory = $1 and owner=$2$_$;


ALTER FUNCTION public.query_subcategory_owner_exists(bigint, bigint) OWNER TO postgres;

--
-- Name: query_subcats(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_subcats() RETURNS SETOF text
    LANGUAGE sql
    AS $$SELECT subcategory FROM subcategory where id != 32 ORDER BY subcategory$$;


ALTER FUNCTION public.query_subcats() OWNER TO postgres;

--
-- Name: query_unapp_user_number(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_unapp_user_number() RETURNS SETOF bigint
    LANGUAGE sql
    AS $$SELECT id FROM owner where approved is not true$$;


ALTER FUNCTION public.query_unapp_user_number() OWNER TO postgres;

--
-- Name: query_unapproved_menu_cats(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_unapproved_menu_cats(OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT DISTINCT get_category(cat) as category, cat FROM recipe_cat_subcat where recipe in(SELECT id FROM recipe where visible is TRUE and approved is not TRUE) ORDER BY category$$;


ALTER FUNCTION public.query_unapproved_menu_cats(OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_unapproved_menu_recipes(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_unapproved_menu_recipes(bigint, bigint, OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT DISTINCT get_recipename(recipe) as recipename, recipe FROM recipe_cat_subcat 

                            WHERE cat = $1 AND subcat = $2 and recipe in(SELECT id FROM recipe where visible is TRUE and approved is not TRUE) ORDER BY recipename$_$;


ALTER FUNCTION public.query_unapproved_menu_recipes(bigint, bigint, OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_unapproved_menu_recipes_no_subcats(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_unapproved_menu_recipes_no_subcats(bigint, OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT DISTINCT get_recipename(recipe) as recipename, recipe FROM recipe_cat_subcat 

                WHERE cat = $1 AND subcat is null and recipe in(SELECT id FROM recipe where visible is TRUE and approved is not TRUE) ORDER BY recipename$_$;


ALTER FUNCTION public.query_unapproved_menu_recipes_no_subcats(bigint, OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_unapproved_menu_subcats(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_unapproved_menu_subcats(bigint, OUT character, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT DISTINCT get_subcategory(subcat) as subcategory , subcat FROM recipe_cat_subcat 

                WHERE cat = $1 and subcat > 0 and recipe in(SELECT id FROM recipe where visible is TRUE and approved is not TRUE) ORDER BY subcategory$_$;


ALTER FUNCTION public.query_unapproved_menu_subcats(bigint, OUT character, OUT bigint) OWNER TO postgres;

--
-- Name: query_unapproved_users(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_unapproved_users(OUT text, OUT text, OUT text, OUT text, OUT date) RETURNS SETOF record
    LANGUAGE sql
    AS $$SELECT owner, fname, lname, email, regdate from owner WHERE approved is false ORDER by owner$$;


ALTER FUNCTION public.query_unapproved_users(OUT text, OUT text, OUT text, OUT text, OUT date) OWNER TO postgres;

--
-- Name: query_unit_exists(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_unit_exists(text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM unit WHERE unit = $1$_$;


ALTER FUNCTION public.query_unit_exists(text) OWNER TO postgres;

--
-- Name: query_unit_name(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_unit_name(bigint) RETURNS SETOF text
    LANGUAGE sql
    AS $_$SELECT unit FROM unit WHERE id = $1$_$;


ALTER FUNCTION public.query_unit_name(bigint) OWNER TO postgres;

--
-- Name: query_unit_owner_exists(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_unit_owner_exists(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM unit_owner WHERE unit = $1 and owner=$2$_$;


ALTER FUNCTION public.query_unit_owner_exists(bigint, bigint) OWNER TO postgres;

--
-- Name: query_upd_aisle_for_ing(bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_aisle_for_ing(bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update ingredient_owner set aisle = $1 where aisle=$2 and owner = $3$_$;


ALTER FUNCTION public.query_upd_aisle_for_ing(bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_upd_cat(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_cat(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update category set category = $1 where id=$2$_$;


ALTER FUNCTION public.query_upd_cat(text, bigint) OWNER TO postgres;

--
-- Name: query_upd_categorys_in_recipes(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_categorys_in_recipes(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe_cat_subcat set cat = $1 where cat=$2$_$;


ALTER FUNCTION public.query_upd_categorys_in_recipes(bigint, bigint) OWNER TO postgres;

--
-- Name: query_upd_ing(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_ing(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update ingredient set ingredient = $1 where id=$2$_$;


ALTER FUNCTION public.query_upd_ing(text, bigint) OWNER TO postgres;

--
-- Name: query_upd_ings_in_recipes(bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_ings_in_recipes(bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe_ing set ing = $1 where ing=$2 and recipe in (select id from recipe where owner=$3)$_$;


ALTER FUNCTION public.query_upd_ings_in_recipes(bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_upd_name_in_recipes(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_name_in_recipes(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set name = $1 where id=$2$_$;


ALTER FUNCTION public.query_upd_name_in_recipes(text, bigint) OWNER TO postgres;

--
-- Name: query_upd_owner(text, text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_owner(text, text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE owner SET fname=$1, email=$2 WHERE id = $3$_$;


ALTER FUNCTION public.query_upd_owner(text, text, bigint) OWNER TO postgres;

--
-- Name: query_upd_owner_admin(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_owner_admin(text) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE owner SET admin=true WHERE owner = $1$_$;


ALTER FUNCTION public.query_upd_owner_admin(text) OWNER TO postgres;

--
-- Name: query_upd_owner_in_recipes(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_owner_in_recipes(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE recipe set owner=$1 where id=$2$_$;


ALTER FUNCTION public.query_upd_owner_in_recipes(bigint, bigint) OWNER TO postgres;

--
-- Name: query_upd_owner_lname(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_owner_lname(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE owner SET lname=$1 WHERE id = $2$_$;


ALTER FUNCTION public.query_upd_owner_lname(text, bigint) OWNER TO postgres;

--
-- Name: query_upd_owner_pass(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_owner_pass(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE owner SET password=$1 WHERE id = $2$_$;


ALTER FUNCTION public.query_upd_owner_pass(text, bigint) OWNER TO postgres;

--
-- Name: query_upd_pp(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_pp(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update preprep set preprep = $1 where id=$2$_$;


ALTER FUNCTION public.query_upd_pp(text, bigint) OWNER TO postgres;

--
-- Name: query_upd_pp_in_recipes(bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_pp_in_recipes(bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe_ing set preprep1 = $1 where preprep1=$2 and recipe in (select id from recipe where owner=$3);

update recipe_ing set preprep2 = $1 where preprep2=$2 and recipe in (select id from recipe where owner=$3)$_$;


ALTER FUNCTION public.query_upd_pp_in_recipes(bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_upd_rating(integer, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_rating(integer, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE recipe_rating SET rating=$1 WHERE rater = $2 and recipe = $3$_$;


ALTER FUNCTION public.query_upd_rating(integer, bigint, bigint) OWNER TO postgres;

--
-- Name: query_upd_recipe(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_recipe(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE recipe SET name=$1 where id=$2$_$;


ALTER FUNCTION public.query_upd_recipe(text, bigint) OWNER TO postgres;

--
-- Name: query_upd_subcat(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_subcat(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update subcategory set subcategory = $1 where id=$2$_$;


ALTER FUNCTION public.query_upd_subcat(text, bigint) OWNER TO postgres;

--
-- Name: query_upd_subcategorys_in_recipes(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_subcategorys_in_recipes(bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe_cat_subcat set subcat = $1 where subcat=$2$_$;


ALTER FUNCTION public.query_upd_subcategorys_in_recipes(bigint, bigint) OWNER TO postgres;

--
-- Name: query_upd_unit(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_unit(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update unit set unit = $1 where id=$2$_$;


ALTER FUNCTION public.query_upd_unit(text, bigint) OWNER TO postgres;

--
-- Name: query_upd_unit_in_recipes(bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_unit_in_recipes(bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe_ing set unit = $1 where unit=$2 and recipe in (select id from recipe where owner=$3);

update recipe_ing set unit2 = $1 where unit2=$2 and recipe in (select id from recipe where owner=$3)$_$;


ALTER FUNCTION public.query_upd_unit_in_recipes(bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_upd_user_admin(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_user_admin() RETURNS void
    LANGUAGE sql
    AS $$UPDATE owner SET admin=false$$;


ALTER FUNCTION public.query_upd_user_admin() OWNER TO postgres;

--
-- Name: query_upd_yield_unit(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_yield_unit(text, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update yield_unit set yield_unit = $1 where id=$2$_$;


ALTER FUNCTION public.query_upd_yield_unit(text, bigint) OWNER TO postgres;

--
-- Name: query_upd_yield_unit_in_recipes(bigint, bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_upd_yield_unit_in_recipes(bigint, bigint, bigint) RETURNS void
    LANGUAGE sql
    AS $_$update recipe set yield_unit = $1 where yield_unit=$2 and owner=$3;$_$;


ALTER FUNCTION public.query_upd_yield_unit_in_recipes(bigint, bigint, bigint) OWNER TO postgres;

--
-- Name: query_update_aisle(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_update_aisle(text, text) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE aisles SET aisle = $1 WHERE aisle=$2$_$;


ALTER FUNCTION public.query_update_aisle(text, text) OWNER TO postgres;

--
-- Name: query_update_owner_admin(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_update_owner_admin(bigint) RETURNS void
    LANGUAGE sql
    AS $_$UPDATE owner SET admin=true WHERE id = $1$_$;


ALTER FUNCTION public.query_update_owner_admin(bigint) OWNER TO postgres;

--
-- Name: query_updated_email_in_use(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_updated_email_in_use(text, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM owner WHERE email = $1 and id != $2$_$;


ALTER FUNCTION public.query_updated_email_in_use(text, bigint) OWNER TO postgres;

--
-- Name: query_user_email(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_user_email(text) RETURNS SETOF text
    LANGUAGE sql
    AS $_$SELECT owner FROM owner WHERE email = $1$_$;


ALTER FUNCTION public.query_user_email(text) OWNER TO postgres;

--
-- Name: query_user_extra_details(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_user_extra_details(text, OUT date, OUT boolean, OUT bigint) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT lastlogin, admin, id from owner where owner=$1$_$;


ALTER FUNCTION public.query_user_extra_details(text, OUT date, OUT boolean, OUT bigint) OWNER TO postgres;

--
-- Name: query_user_number(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_user_number() RETURNS SETOF bigint
    LANGUAGE sql
    AS $$SELECT id FROM owner where approved is true$$;


ALTER FUNCTION public.query_user_number() OWNER TO postgres;

--
-- Name: query_user_prefs(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--
--
-- Name: query_user_recipe_number(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_user_recipe_number(bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM recipe where owner=$1 and visible is TRUE and approved is TRUE$_$;


ALTER FUNCTION public.query_user_recipe_number(bigint) OWNER TO postgres;

--
-- Name: query_user_recipes_with_name(text, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_user_recipes_with_name(text, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM recipe where name ILIKE $1 and owner=$2$_$;


ALTER FUNCTION public.query_user_recipes_with_name(text, bigint) OWNER TO postgres;

--
-- Name: query_user_recipes_with_name_id(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_user_recipes_with_name_id(bigint, OUT bigint, OUT text) RETURNS SETOF record
    LANGUAGE sql
    AS $_$SELECT id, name FROM recipe where owner=$1 and visible is TRUE and approved is true ORDER BY name$_$;


ALTER FUNCTION public.query_user_recipes_with_name_id(bigint, OUT bigint, OUT text) OWNER TO postgres;

--
-- Name: query_user_welcome_pref(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_user_welcome_pref(bigint, OUT boolean) RETURNS SETOF boolean
    LANGUAGE sql
    AS $_$select welcome from owner where id=$1$_$;


ALTER FUNCTION public.query_user_welcome_pref(bigint, OUT boolean) OWNER TO postgres;

--
-- Name: query_yield_unit_exists(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_yield_unit_exists(text) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM yield_unit WHERE yield_unit = $1$_$;


ALTER FUNCTION public.query_yield_unit_exists(text) OWNER TO postgres;

--
-- Name: query_yield_unit_name(bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_yield_unit_name(bigint) RETURNS SETOF text
    LANGUAGE sql
    AS $_$SELECT yield_unit FROM yield_unit WHERE id = $1$_$;


ALTER FUNCTION public.query_yield_unit_name(bigint) OWNER TO postgres;

--
-- Name: query_yield_unit_owner_exists(bigint, bigint); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION query_yield_unit_owner_exists(bigint, bigint) RETURNS SETOF bigint
    LANGUAGE sql
    AS $_$SELECT id FROM yield_unit_owner WHERE yield_unit = $1 and owner=$2$_$;


ALTER FUNCTION public.query_yield_unit_owner_exists(bigint, bigint) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;



--
-- Name: yield_unit_owner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE yield_unit_owner_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.yield_unit_owner_id_seq OWNER TO postgres;

--
-- Name: yield_unit_owner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE yield_unit_owner_id_seq OWNED BY yield_unit_owner.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY aisles ALTER COLUMN id SET DEFAULT nextval('aisles_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY category ALTER COLUMN id SET DEFAULT nextval('category_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY category_owner ALTER COLUMN id SET DEFAULT nextval('category_owner_id_seq'::regclass);


--
-- Name: commentid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY comments ALTER COLUMN commentid SET DEFAULT nextval('comments_commentid_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cuisine ALTER COLUMN id SET DEFAULT nextval('cuisine_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cuisine_owner ALTER COLUMN id SET DEFAULT nextval('cuisine_owner_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diet ALTER COLUMN id SET DEFAULT nextval('diet_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diet_owner ALTER COLUMN id SET DEFAULT nextval('diet_owner_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY excluded_ing ALTER COLUMN id SET DEFAULT nextval('excluded_ing_id_seq'::regclass);


--
-- Name: favid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY favourites ALTER COLUMN favid SET DEFAULT nextval('favourites_favid_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY image ALTER COLUMN id SET DEFAULT nextval('image_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ingredient ALTER COLUMN id SET DEFAULT nextval('ingredient_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ingredient_owner ALTER COLUMN id SET DEFAULT nextval('ingredient_owner_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY measure ALTER COLUMN id SET DEFAULT nextval('measures_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY measure_owner ALTER COLUMN id SET DEFAULT nextval('measure_owner_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY menu ALTER COLUMN id SET DEFAULT nextval('menu_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY menu_recipe ALTER COLUMN id SET DEFAULT nextval('menu_recipe_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY owner ALTER COLUMN id SET DEFAULT nextval('owner_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preprep ALTER COLUMN id SET DEFAULT nextval('preprep_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preprep_owner ALTER COLUMN id SET DEFAULT nextval('preprep_owner_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY rating ALTER COLUMN id SET DEFAULT nextval('rating_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe ALTER COLUMN id SET DEFAULT nextval('recipe_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_cat_subcat ALTER COLUMN id SET DEFAULT nextval('recipe_cat_subcat_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_diet ALTER COLUMN id SET DEFAULT nextval('recipe_diet_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_ing ALTER COLUMN id SET DEFAULT nextval('recipe_ing_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_rating ALTER COLUMN id SET DEFAULT nextval('recipe_rating_id_seq'::regclass);

--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY server ALTER COLUMN id SET DEFAULT nextval('server_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY shopping_list ALTER COLUMN id SET DEFAULT nextval('shopping_list_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY shopping_list_entry ALTER COLUMN id SET DEFAULT nextval('"shopping-list_entry_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY source ALTER COLUMN id SET DEFAULT nextval('source_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY source_owner ALTER COLUMN id SET DEFAULT nextval('source_owner_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subcategory ALTER COLUMN id SET DEFAULT nextval('subcategory_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subcategory_owner ALTER COLUMN id SET DEFAULT nextval('subcategory_owner_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY unit ALTER COLUMN id SET DEFAULT nextval('unit_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY unit_owner ALTER COLUMN id SET DEFAULT nextval('unit_owner_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY yield_unit ALTER COLUMN id SET DEFAULT nextval('yield_unit_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY yield_unit_owner ALTER COLUMN id SET DEFAULT nextval('yield_unit_owner_id_seq'::regclass);


--
-- Data for Name: aisles; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: aisles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('aisles_id_seq', 4, true);


--
-- Data for Name: category; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO category VALUES ('Uncategorised
', 20);


--
-- Name: category_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('category_id_seq', 30, true);


--
-- Data for Name: category_owner; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: category_owner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('category_owner_id_seq', 1, false);


--
-- Data for Name: comments; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: comments_commentid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('comments_commentid_seq', 5, true);


--
-- Data for Name: cuisine; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: cuisine_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('cuisine_id_seq', 5, true);


--
-- Data for Name: cuisine_owner; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: cuisine_owner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('cuisine_owner_id_seq', 1, false);


--
-- Data for Name: diet; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: diet_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('diet_id_seq', 4, true);


--
-- Data for Name: diet_owner; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: diet_owner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('diet_owner_id_seq', 1, false);


--
-- Data for Name: excluded_ing; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: excluded_ing_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('excluded_ing_id_seq', 3, true);


--
-- Data for Name: favourites; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: favourites_favid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('favourites_favid_seq', 4, true);


--
-- Data for Name: image; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: image_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('image_id_seq', 1, false);


--
-- Data for Name: ingredient; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: ingredient_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('ingredient_id_seq', 200, true);


--
-- Data for Name: ingredient_owner; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: ingredient_owner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('ingredient_owner_id_seq', 8, true);


--
-- Data for Name: measure; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO measure VALUES (18, 'Imperial');
INSERT INTO measure VALUES (19, 'Metric');
INSERT INTO measure VALUES (20, 'Metric (AU)');
INSERT INTO measure VALUES (21, 'Metric (UK)');
INSERT INTO measure VALUES (22, 'US');


--
-- Data for Name: measure_owner; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: measure_owner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('measure_owner_id_seq', 1, false);


--
-- Name: measures_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('measures_id_seq', 22, true);


--
-- Data for Name: menu; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('menu_id_seq', 2, true);


--
-- Data for Name: menu_recipe; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: menu_recipe_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('menu_recipe_id_seq', 2, true);


--
-- Data for Name: owner; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO owner (owner,password,admin,approved) VALUES ('mywrm','$P$BOp/cs7eOs6awPehCCrU4O8rC9TycG1',true, true);


--
-- Name: owner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('owner_id_seq', 147, true);


--
-- Data for Name: preprep; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: preprep_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('preprep_id_seq', 68, true);


--
-- Data for Name: preprep_owner; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: preprep_owner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('preprep_owner_id_seq', 1, false);


--
-- Data for Name: rating; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO rating VALUES ('1 Star', 0);
INSERT INTO rating VALUES ('2 Stars', 1);
INSERT INTO rating VALUES ('3 Stars', 2);
INSERT INTO rating VALUES ('4 Stars', 3);
INSERT INTO rating VALUES ('5 Stars', 4);


--
-- Name: rating_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('rating_id_seq', 4, true);


--
-- Data for Name: recipe; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: recipe_cat_subcat; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: recipe_cat_subcat_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('recipe_cat_subcat_id_seq', 69, true);


--
-- Data for Name: recipe_diet; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: recipe_diet_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('recipe_diet_id_seq', 27, true);


--
-- Name: recipe_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('recipe_id_seq', 28, true);


--
-- Data for Name: recipe_image; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: recipe_ing; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: recipe_ing_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('recipe_ing_id_seq', 416, true);


--
-- Data for Name: recipe_rating; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: recipe_rating_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('recipe_rating_id_seq', 19, true);


--
-- Data for Name: recipe_recipe; Type: TABLE DATA; Schema: public; Owner: postgres
--

--
-- Data for Name: server; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO server VALUES ('', 9, '2014-07-06');


--
-- Name: server_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('server_id_seq', 9, true);


--
-- Name: shopping-list_entry_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"shopping-list_entry_id_seq"', 3, true);


--
-- Data for Name: shopping_list; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: shopping_list_entry; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: shopping_list_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('shopping_list_id_seq', 3, true);


--
-- Data for Name: source; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: source_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('source_id_seq', 9, true);


--
-- Data for Name: source_owner; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: source_owner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('source_owner_id_seq', 1, false);


--
-- Data for Name: subcategory; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO subcategory VALUES ('Uncategorised
', 32);


--
-- Name: subcategory_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('subcategory_id_seq', 16, true);


--
-- Data for Name: subcategory_owner; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: subcategory_owner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('subcategory_owner_id_seq', 1, false);


--
-- Data for Name: unit; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: unit_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('unit_id_seq', 84, true);


--
-- Data for Name: unit_owner; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: unit_owner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('unit_owner_id_seq', 1, false);


--
-- Data for Name: yield_unit; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: yield_unit_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('yield_unit_id_seq', 17, true);


--
-- Data for Name: yield_unit_owner; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: yield_unit_owner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('yield_unit_owner_id_seq', 1, false);


--
-- Name: aisles_aisle_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY aisles
    ADD CONSTRAINT aisles_aisle_key UNIQUE (aisle);


--
-- Name: aisles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY aisles
    ADD CONSTRAINT aisles_pkey PRIMARY KEY (id);


--
-- Name: category_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY category
    ADD CONSTRAINT category_id_key UNIQUE (id);


--
-- Name: category_owner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY category_owner
    ADD CONSTRAINT category_owner_pkey PRIMARY KEY (id);


--
-- Name: category_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY category
    ADD CONSTRAINT category_pkey PRIMARY KEY (id);


--
-- Name: comments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY comments
    ADD CONSTRAINT comments_pkey PRIMARY KEY (commentid);


--
-- Name: cuisine_owner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cuisine_owner
    ADD CONSTRAINT cuisine_owner_pkey PRIMARY KEY (id);


--
-- Name: cuisine_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cuisine
    ADD CONSTRAINT cuisine_pkey PRIMARY KEY (id);


--
-- Name: diet_owner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diet_owner
    ADD CONSTRAINT diet_owner_pkey PRIMARY KEY (id);


--
-- Name: diet_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diet
    ADD CONSTRAINT diet_pkey PRIMARY KEY (id);


--
-- Name: excluded_ing_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY excluded_ing
    ADD CONSTRAINT excluded_ing_pkey PRIMARY KEY (id);


--
-- Name: favourites_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY favourites
    ADD CONSTRAINT favourites_pkey PRIMARY KEY (favid);


--
-- Name: image_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY image
    ADD CONSTRAINT image_pkey PRIMARY KEY (id);


--
-- Name: ingredient_owner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ingredient_owner
    ADD CONSTRAINT ingredient_owner_pkey PRIMARY KEY (id);


--
-- Name: ingredient_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ingredient
    ADD CONSTRAINT ingredient_pkey PRIMARY KEY (id);


--
-- Name: measure_owner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY measure_owner
    ADD CONSTRAINT measure_owner_pkey PRIMARY KEY (id);


--
-- Name: measure_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY measure
    ADD CONSTRAINT measure_pkey PRIMARY KEY (id);


--
-- Name: menu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_pkey PRIMARY KEY (id);


--
-- Name: menu_recipe_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_recipe
    ADD CONSTRAINT menu_recipe_pkey PRIMARY KEY (id);


--
-- Name: owner_owner_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY owner
    ADD CONSTRAINT owner_owner_key UNIQUE (owner);


--
-- Name: owner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--


--
-- Name: preprep_owner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY preprep_owner
    ADD CONSTRAINT preprep_owner_pkey PRIMARY KEY (id);


--
-- Name: preprep_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY preprep
    ADD CONSTRAINT preprep_pkey PRIMARY KEY (id);


--
-- Name: rating_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY rating
    ADD CONSTRAINT rating_pkey PRIMARY KEY (id);


--
-- Name: recipe_cat_subcat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY recipe_cat_subcat
    ADD CONSTRAINT recipe_cat_subcat_pkey PRIMARY KEY (id);


--
-- Name: recipe_diet_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY recipe_diet
    ADD CONSTRAINT recipe_diet_pkey PRIMARY KEY (id);


--
-- Name: recipe_ing_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY recipe_ing
    ADD CONSTRAINT recipe_ing_pkey PRIMARY KEY (id);


--
-- Name: recipe_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY recipe
    ADD CONSTRAINT recipe_pkey PRIMARY KEY (id);


--
-- Name: recipe_rating_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY recipe_rating
    ADD CONSTRAINT recipe_rating_pkey PRIMARY KEY (id);

--
-- Name: server_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY server
    ADD CONSTRAINT server_pkey PRIMARY KEY (id);


--
-- Name: shopping-list_entry_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY shopping_list_entry
    ADD CONSTRAINT "shopping-list_entry_pkey" PRIMARY KEY (id);


--
-- Name: shopping_list_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY shopping_list
    ADD CONSTRAINT shopping_list_pkey PRIMARY KEY (id);


--
-- Name: source_owner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY source_owner
    ADD CONSTRAINT source_owner_pkey PRIMARY KEY (id);


--
-- Name: source_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY source
    ADD CONSTRAINT source_pkey PRIMARY KEY (id);


--
-- Name: subcategory_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY subcategory
    ADD CONSTRAINT subcategory_id_key UNIQUE (id);


--
-- Name: subcategory_owner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY subcategory_owner
    ADD CONSTRAINT subcategory_owner_pkey PRIMARY KEY (id);


--
-- Name: subcategory_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY subcategory
    ADD CONSTRAINT subcategory_pkey PRIMARY KEY (id);


--
-- Name: unit_owner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY unit_owner
    ADD CONSTRAINT unit_owner_pkey PRIMARY KEY (id);


--
-- Name: unit_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY unit
    ADD CONSTRAINT unit_pkey PRIMARY KEY (id);


--
-- Name: yield_unit_owner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY yield_unit_owner
    ADD CONSTRAINT yield_unit_owner_pkey PRIMARY KEY (id);


--
-- Name: yield_unit_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY yield_unit
    ADD CONSTRAINT yield_unit_pkey PRIMARY KEY (id);


--
-- Name: category_owner_category_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY category_owner
    ADD CONSTRAINT category_owner_category_fkey FOREIGN KEY (category) REFERENCES category(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: category_owner_owner_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY category_owner
    ADD CONSTRAINT category_owner_owner_fkey FOREIGN KEY (owner) REFERENCES owner(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: cuisine_owner_cuisine_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cuisine_owner
    ADD CONSTRAINT cuisine_owner_cuisine_fkey FOREIGN KEY (cuisine) REFERENCES cuisine(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: cuisine_owner_owner_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cuisine_owner
    ADD CONSTRAINT cuisine_owner_owner_fkey FOREIGN KEY (owner) REFERENCES owner(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: diet_owner_diet_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diet_owner
    ADD CONSTRAINT diet_owner_diet_fkey FOREIGN KEY (diet) REFERENCES diet(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: diet_owner_owner_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diet_owner
    ADD CONSTRAINT diet_owner_owner_fkey FOREIGN KEY (owner) REFERENCES owner(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: excluded_ing_ing_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY excluded_ing
    ADD CONSTRAINT excluded_ing_ing_fkey FOREIGN KEY (ing) REFERENCES ingredient(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: excluded_ing_owner_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY excluded_ing
    ADD CONSTRAINT excluded_ing_owner_fkey FOREIGN KEY (owner) REFERENCES owner(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: favourites_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY favourites
    ADD CONSTRAINT favourites_id_fkey FOREIGN KEY (id) REFERENCES recipe(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ingredient_owner_aisle_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ingredient_owner
    ADD CONSTRAINT ingredient_owner_aisle_fkey FOREIGN KEY (aisle) REFERENCES aisles(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ingredient_owner_ingredient_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ingredient_owner
    ADD CONSTRAINT ingredient_owner_ingredient_fkey FOREIGN KEY (ingredient) REFERENCES ingredient(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ingredient_owner_owner_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ingredient_owner
    ADD CONSTRAINT ingredient_owner_owner_fkey FOREIGN KEY (owner) REFERENCES owner(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: measure_owner_measure_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY measure_owner
    ADD CONSTRAINT measure_owner_measure_fkey FOREIGN KEY (measure) REFERENCES measure(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: measure_owner_owner_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY measure_owner
    ADD CONSTRAINT measure_owner_owner_fkey FOREIGN KEY (owner) REFERENCES owner(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: menu_recipe_menu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY menu_recipe
    ADD CONSTRAINT menu_recipe_menu_fkey FOREIGN KEY (menu) REFERENCES menu(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: menu_recipe_recipe_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY menu_recipe
    ADD CONSTRAINT menu_recipe_recipe_fkey FOREIGN KEY (recipe) REFERENCES recipe(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: preprep_owner_owner_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preprep_owner
    ADD CONSTRAINT preprep_owner_owner_fkey FOREIGN KEY (owner) REFERENCES owner(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: preprep_owner_preprep_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preprep_owner
    ADD CONSTRAINT preprep_owner_preprep_fkey FOREIGN KEY (preprep) REFERENCES preprep(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_cat_subcat_cat_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_cat_subcat
    ADD CONSTRAINT recipe_cat_subcat_cat_fkey FOREIGN KEY (cat) REFERENCES category(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_cat_subcat_recipe_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_cat_subcat
    ADD CONSTRAINT recipe_cat_subcat_recipe_fkey FOREIGN KEY (recipe) REFERENCES recipe(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_cat_subcat_subcat_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_cat_subcat
    ADD CONSTRAINT recipe_cat_subcat_subcat_fkey FOREIGN KEY (subcat) REFERENCES subcategory(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_diet_diet_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_diet
    ADD CONSTRAINT recipe_diet_diet_fkey FOREIGN KEY (diet) REFERENCES diet(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_diet_recipe_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_diet
    ADD CONSTRAINT recipe_diet_recipe_fkey FOREIGN KEY (recipe) REFERENCES recipe(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_image_image_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_image
    ADD CONSTRAINT recipe_image_image_fkey FOREIGN KEY (image) REFERENCES image(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_image_recipe_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_image
    ADD CONSTRAINT recipe_image_recipe_fkey FOREIGN KEY (recipe) REFERENCES recipe(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_ing_ing_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_ing
    ADD CONSTRAINT recipe_ing_ing_fkey FOREIGN KEY (ing) REFERENCES ingredient(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_ing_preprep1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_ing
    ADD CONSTRAINT recipe_ing_preprep1_fkey FOREIGN KEY (preprep1) REFERENCES preprep(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_ing_preprep2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_ing
    ADD CONSTRAINT recipe_ing_preprep2_fkey FOREIGN KEY (preprep2) REFERENCES preprep(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_ing_recipe_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_ing
    ADD CONSTRAINT recipe_ing_recipe_fkey FOREIGN KEY (recipe) REFERENCES recipe(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_ing_unit2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_ing
    ADD CONSTRAINT recipe_ing_unit2_fkey FOREIGN KEY (unit2) REFERENCES unit(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_ing_unit_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_ing
    ADD CONSTRAINT recipe_ing_unit_fkey FOREIGN KEY (unit) REFERENCES unit(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_rating_recipe_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_rating
    ADD CONSTRAINT recipe_rating_recipe_fkey FOREIGN KEY (recipe) REFERENCES recipe(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_recipe_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_recipe
    ADD CONSTRAINT recipe_recipe_id_fkey FOREIGN KEY (id) REFERENCES recipe(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: recipe_recipe_related_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recipe_recipe
    ADD CONSTRAINT recipe_recipe_related_id_fkey FOREIGN KEY (related_id) REFERENCES recipe(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: shopping-list_entry_list_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY shopping_list_entry
    ADD CONSTRAINT "shopping-list_entry_list_fkey" FOREIGN KEY (list) REFERENCES shopping_list(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: shopping_list_entry_ing_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY shopping_list_entry
    ADD CONSTRAINT shopping_list_entry_ing_fkey FOREIGN KEY (ing) REFERENCES ingredient(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: source_owner_owner_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY source_owner
    ADD CONSTRAINT source_owner_owner_fkey FOREIGN KEY (owner) REFERENCES owner(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: source_owner_source_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY source_owner
    ADD CONSTRAINT source_owner_source_fkey FOREIGN KEY (source) REFERENCES source(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: subcategory_owner_owner_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subcategory_owner
    ADD CONSTRAINT subcategory_owner_owner_fkey FOREIGN KEY (owner) REFERENCES owner(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: subcategory_owner_subcategory_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subcategory_owner
    ADD CONSTRAINT subcategory_owner_subcategory_fkey FOREIGN KEY (subcategory) REFERENCES subcategory(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: unit_owner_owner_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY unit_owner
    ADD CONSTRAINT unit_owner_owner_fkey FOREIGN KEY (owner) REFERENCES owner(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: unit_owner_unit_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY unit_owner
    ADD CONSTRAINT unit_owner_unit_fkey FOREIGN KEY (unit) REFERENCES unit(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: yield_unit_owner_owner_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY yield_unit_owner
    ADD CONSTRAINT yield_unit_owner_owner_fkey FOREIGN KEY (owner) REFERENCES owner(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: yield_unit_owner_yield_unit_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY yield_unit_owner
    ADD CONSTRAINT yield_unit_owner_yield_unit_fkey FOREIGN KEY (yield_unit) REFERENCES yield_unit(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- Name: category; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE category FROM PUBLIC;
REVOKE ALL ON TABLE category FROM postgres;
GRANT ALL ON TABLE category TO postgres;


--
-- Name: category_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE category_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE category_id_seq FROM postgres;
GRANT ALL ON SEQUENCE category_id_seq TO postgres;


--
-- Name: cuisine; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE cuisine FROM PUBLIC;
REVOKE ALL ON TABLE cuisine FROM postgres;
GRANT ALL ON TABLE cuisine TO postgres;


--
-- Name: cuisine_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE cuisine_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE cuisine_id_seq FROM postgres;
GRANT ALL ON SEQUENCE cuisine_id_seq TO postgres;


--
-- Name: diet; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE diet FROM PUBLIC;
REVOKE ALL ON TABLE diet FROM postgres;
GRANT ALL ON TABLE diet TO postgres;


--
-- Name: diet_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE diet_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE diet_id_seq FROM postgres;
GRANT ALL ON SEQUENCE diet_id_seq TO postgres;


--
-- Name: ingredient; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE ingredient FROM PUBLIC;
REVOKE ALL ON TABLE ingredient FROM postgres;
GRANT ALL ON TABLE ingredient TO postgres;


--
-- Name: ingredient_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE ingredient_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE ingredient_id_seq FROM postgres;
GRANT ALL ON SEQUENCE ingredient_id_seq TO postgres;


--
-- Name: measure; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE measure FROM PUBLIC;
REVOKE ALL ON TABLE measure FROM postgres;
GRANT ALL ON TABLE measure TO postgres;


--
-- Name: measures_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE measures_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE measures_id_seq FROM postgres;
GRANT ALL ON SEQUENCE measures_id_seq TO postgres;


--
-- Name: preprep; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE preprep FROM PUBLIC;
REVOKE ALL ON TABLE preprep FROM postgres;
GRANT ALL ON TABLE preprep TO postgres;


--
-- Name: preprep_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE preprep_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE preprep_id_seq FROM postgres;
GRANT ALL ON SEQUENCE preprep_id_seq TO postgres;


--
-- Name: rating; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE rating FROM PUBLIC;
REVOKE ALL ON TABLE rating FROM postgres;
GRANT ALL ON TABLE rating TO postgres;


--
-- Name: rating_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE rating_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE rating_id_seq FROM postgres;
GRANT ALL ON SEQUENCE rating_id_seq TO postgres;


--
-- Name: recipe; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE recipe FROM PUBLIC;
REVOKE ALL ON TABLE recipe FROM postgres;
GRANT ALL ON TABLE recipe TO postgres;


--
-- Name: recipe_cat_subcat; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE recipe_cat_subcat FROM PUBLIC;
REVOKE ALL ON TABLE recipe_cat_subcat FROM postgres;
GRANT ALL ON TABLE recipe_cat_subcat TO postgres;


--
-- Name: recipe_cat_subcat_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE recipe_cat_subcat_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE recipe_cat_subcat_id_seq FROM postgres;
GRANT ALL ON SEQUENCE recipe_cat_subcat_id_seq TO postgres;


--
-- Name: recipe_diet; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE recipe_diet FROM PUBLIC;
REVOKE ALL ON TABLE recipe_diet FROM postgres;
GRANT ALL ON TABLE recipe_diet TO postgres;


--
-- Name: recipe_diet_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE recipe_diet_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE recipe_diet_id_seq FROM postgres;
GRANT ALL ON SEQUENCE recipe_diet_id_seq TO postgres;


--
-- Name: recipe_ing; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE recipe_ing FROM PUBLIC;
REVOKE ALL ON TABLE recipe_ing FROM postgres;
GRANT ALL ON TABLE recipe_ing TO postgres;


--
-- Name: recipe_ing_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE recipe_ing_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE recipe_ing_id_seq FROM postgres;
GRANT ALL ON SEQUENCE recipe_ing_id_seq TO postgres;


--
-- Name: recipe_recipe; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE recipe_recipe FROM PUBLIC;
REVOKE ALL ON TABLE recipe_recipe FROM postgres;
GRANT ALL ON TABLE recipe_recipe TO postgres;


--
-- Name: source; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE source FROM PUBLIC;
REVOKE ALL ON TABLE source FROM postgres;
GRANT ALL ON TABLE source TO postgres;


--
-- Name: source_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE source_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE source_id_seq FROM postgres;
GRANT ALL ON SEQUENCE source_id_seq TO postgres;


--
-- Name: subcategory; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE subcategory FROM PUBLIC;
REVOKE ALL ON TABLE subcategory FROM postgres;
GRANT ALL ON TABLE subcategory TO postgres;


--
-- Name: subcategory_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE subcategory_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE subcategory_id_seq FROM postgres;
GRANT ALL ON SEQUENCE subcategory_id_seq TO postgres;


--
-- Name: unit; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE unit FROM PUBLIC;
REVOKE ALL ON TABLE unit FROM postgres;
GRANT ALL ON TABLE unit TO postgres;


--
-- Name: unit_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE unit_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE unit_id_seq FROM postgres;
GRANT ALL ON SEQUENCE unit_id_seq TO postgres;


--
-- Name: yield_unit; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE yield_unit FROM PUBLIC;
REVOKE ALL ON TABLE yield_unit FROM postgres;
GRANT ALL ON TABLE yield_unit TO postgres;


--
-- Name: yield_unit_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE yield_unit_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE yield_unit_id_seq FROM postgres;
GRANT ALL ON SEQUENCE yield_unit_id_seq TO postgres;

CREATE OR REPLACE FUNCTION query_sources(OUT character, OUT bigint)
  RETURNS SETOF record AS
'SELECT source, id FROM source WHERE id IN (SELECT DISTINCT source FROM recipe) ORDER BY source'
  LANGUAGE sql VOLATILE
  COST 100
  ROWS 1000;
  
alter table owner add gpref boolean;

CREATE OR REPLACE FUNCTION query_upd_owner_guest(text)
  RETURNS void AS
'UPDATE owner SET guest=true WHERE owner = $1'
  LANGUAGE sql VOLATILE
  COST 100;
  
DROP FUNCTION query_user_extra_details(text);

CREATE OR REPLACE FUNCTION query_user_extra_details(IN text, OUT date, OUT boolean, OUT bigint, OUT boolean)
  RETURNS SETOF record AS
'SELECT lastlogin, admin, id, guest from owner where owner=$1'
  LANGUAGE sql VOLATILE
  COST 100
  ROWS 1000;
  
CREATE OR REPLACE FUNCTION query_upd_user_guest(bigint)
  RETURNS void AS
'UPDATE owner SET guest=false'
  LANGUAGE sql VOLATILE
  COST 100;
  
CREATE OR REPLACE FUNCTION query_update_owner_guest(bigint)
  RETURNS void AS
'UPDATE owner SET guest=true WHERE id = $1'
  LANGUAGE sql VOLATILE
  COST 100;
  
CREATE OR REPLACE FUNCTION query_owner_is_guest(character)
  RETURNS SETOF boolean AS
'SELECT guest from owner where owner=$1 and guest is true'
  LANGUAGE sql VOLATILE
  COST 100
  ROWS 1000;
  
DROP FUNCTION query_add_eboption_prefs(boolean, boolean, boolean, boolean, boolean, bigint);

CREATE OR REPLACE FUNCTION query_add_eboption_prefs(boolean, boolean, boolean, boolean, boolean, bigint, boolean)
  RETURNS void AS
'update owner set toc = $1, catt= $2, welcome = $3, pdf=$4, rapp=$5, gpref=$7 where id=$6'
  LANGUAGE sql VOLATILE
  COST 100;

CREATE OR REPLACE FUNCTION query_user_prefs(IN bigint, OUT boolean, OUT boolean, OUT bigint, OUT bigint, OUT text, OUT bigint, OUT character, OUT boolean, OUT boolean, OUT bigint, OUT bigint, OUT bigint, OUT bigint)
  RETURNS SETOF record AS
'select toc, catt, datefmt,measure,ebtitle,paper,get_measure(measure) as msname, pdf, rapp, numfmt, fracdec, region, groroz from owner where id=$1'
  LANGUAGE sql VOLATILE
  COST 100
  ROWS 1000;                                                                                  
  
CREATE TABLE region
(
  id bigserial NOT NULL,
  region text,
  CONSTRAINT region_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);

insert into region  (region) values('USA');
insert into region  (region) values('UK');
insert into region  (region) values('Australia');
insert into region  (region) values('Metric');
insert into region  (region) values('New Zealand');
insert into region  (region) values('Canada');

CREATE OR REPLACE FUNCTION query_regions(OUT bigint, OUT text)
  RETURNS SETOF record AS
'SELECT id, region from region ORDER BY region'
  LANGUAGE sql VOLATILE
  COST 100
  ROWS 1000;
  
CREATE OR REPLACE FUNCTION query_add_region_pref(bigint, bigint)
  RETURNS void AS
'update owner set region = $1 where id=$2'
  LANGUAGE sql VOLATILE
  COST 100;
  
CREATE OR REPLACE FUNCTION query_add_numfmt_pref(bigint, bigint)
  RETURNS void AS
'update owner set numfmt= $1 where id=$2'
  LANGUAGE sql VOLATILE
  COST 100;
  
CREATE OR REPLACE FUNCTION query_add_fracdec_pref(bigint, bigint)
  RETURNS void AS
'update owner set fracdec= $1 where id=$2'
  LANGUAGE sql VOLATILE
  COST 100;
  
DROP FUNCTION query_add_eboption_prefs(boolean, boolean, boolean, boolean, boolean, bigint, boolean);

CREATE OR REPLACE FUNCTION query_add_eboption_prefs(boolean, boolean, boolean, boolean, boolean, bigint)
  RETURNS void AS
'update owner set toc = $1, catt= $2, welcome = $3, pdf=$4, rapp=$5 where id=$6'
  LANGUAGE sql VOLATILE
  COST 100;

CREATE TABLE unit_base (
    id bigint NOT NULL,
    unit text,
    base text,
    mmf text
);
 
CREATE SEQUENCE unit_base_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE unit_base_id_seq OWNED BY unit_base.id;


ALTER TABLE ONLY unit_base ALTER COLUMN id SET DEFAULT nextval('unit_base_id_seq'::regclass);

INSERT INTO unit_base VALUES (140, 'cloves', 'clove', 'cv');
INSERT INTO unit_base VALUES (141, 'clove', 'clove', 'cv');
INSERT INTO unit_base VALUES (12, 'extra lg', 'extra large', 'xl');
INSERT INTO unit_base VALUES (100, 'ball', 'ball', 'bl');
INSERT INTO unit_base VALUES (106, 'blocks', 'block', 'bk');
INSERT INTO unit_base VALUES (109, 'bt', 'bottle', 'bt');
INSERT INTO unit_base VALUES (98, 'bg', 'bag', 'bg');
INSERT INTO unit_base VALUES (104, 'baskets', 'basket', 'bs');
INSERT INTO unit_base VALUES (101, 'bar', 'bar', 'br');
INSERT INTO unit_base VALUES (117, 'bulbs', 'bulb', 'bb');
INSERT INTO unit_base VALUES (111, 'boxes', 'box', 'bx');
INSERT INTO unit_base VALUES (103, 'basket', 'basket', 'bs');
INSERT INTO unit_base VALUES (124, 'cans', 'can', 'cn');
INSERT INTO unit_base VALUES (108, 'bottle', 'bottle', 'bt');
INSERT INTO unit_base VALUES (118, 'bulb', 'bulb', 'bb');
INSERT INTO unit_base VALUES (96, 'bags', 'bag', 'bg');
INSERT INTO unit_base VALUES (5, 'fluid oz', 'fluid ounce', 'fl');
INSERT INTO unit_base VALUES (125, 'can', 'can', 'cn');
INSERT INTO unit_base VALUES (163, 'dashes', 'dash', 'ds');
INSERT INTO unit_base VALUES (135, 'ct', 'carton', 'ct');
INSERT INTO unit_base VALUES (123, 'bn', 'bunch', 'bn');
INSERT INTO unit_base VALUES (132, 'carton', 'carton', 'ct');
INSERT INTO unit_base VALUES (3, 'fluid ounce', 'fluid ounce', 'fl');
INSERT INTO unit_base VALUES (122, 'bunch', 'bunch', 'bn');
INSERT INTO unit_base VALUES (121, 'bunchs', 'bunch', 'bn');
INSERT INTO unit_base VALUES (1, 'fl oz', 'fluid ounce', 'fl');
INSERT INTO unit_base VALUES (162, 'c', 'cup', 'c');
INSERT INTO unit_base VALUES (161, 'c.', 'cup', 'c');
INSERT INTO unit_base VALUES (6, 'fluid ozs', 'fluid ounce', 'fl');
INSERT INTO unit_base VALUES (160, 'cp', 'cup', 'c');
INSERT INTO unit_base VALUES (159, 'cps', 'cup', 'c');
INSERT INTO unit_base VALUES (158, 'cup', 'cup', 'c');
INSERT INTO unit_base VALUES (157, 'cups', 'cup', 'c');
INSERT INTO unit_base VALUES (147, 'cl', 'centiliter', 'cl');
INSERT INTO unit_base VALUES (149, 'c/ls', 'centiliter', 'cl');
INSERT INTO unit_base VALUES (142, 'cls', 'centiliter', 'cl');
INSERT INTO unit_base VALUES (137, 'centigrams', 'centigram', 'cg');
INSERT INTO unit_base VALUES (138, 'centigram', 'centigram', 'cg');
INSERT INTO unit_base VALUES (134, 'ctn', 'carton', 'ct');
INSERT INTO unit_base VALUES (107, 'bottles', 'bottle', 'bt');
INSERT INTO unit_base VALUES (133, 'ctns', 'carton', 'ct');
INSERT INTO unit_base VALUES (112, 'boxs', 'box', 'bx');
INSERT INTO unit_base VALUES (116, 'branches', 'branch', 'bc');
INSERT INTO unit_base VALUES (113, 'box', 'box', 'bx');
INSERT INTO unit_base VALUES (129, 'capfull', 'capful', 'cf');
INSERT INTO unit_base VALUES (115, 'branch', 'branch', 'bc');
INSERT INTO unit_base VALUES (130, 'capfulls', 'capful', 'cf');
INSERT INTO unit_base VALUES (156, 'cb', 'cube', 'cb');
INSERT INTO unit_base VALUES (154, 'cubes', 'cube', 'cb');
INSERT INTO unit_base VALUES (10, 'cap full', 'capful', 'cf');
INSERT INTO unit_base VALUES (155, 'cube', 'cube', 'cb');
INSERT INTO unit_base VALUES (144, 'centiliters', 'centiliter', 'cl');
INSERT INTO unit_base VALUES (126, 'cn', 'can', 'cn');
INSERT INTO unit_base VALUES (143, 'centilitres', 'centiliter', 'cl');
INSERT INTO unit_base VALUES (153, 'containers', 'container', 'co');
INSERT INTO unit_base VALUES (151, 'cm', 'centimeter', 'cm');
INSERT INTO unit_base VALUES (152, 'container', 'container', 'co');
INSERT INTO unit_base VALUES (13, 'dessert spoon', 'dessertspoon', 'd');
INSERT INTO unit_base VALUES (18, 'heaped cup', 'heaped cup', 'hc');
INSERT INTO unit_base VALUES (20, 'heaped c', 'heaped cup', 'hc');
INSERT INTO unit_base VALUES (33, 'heaped tbsp', 'heaped tablespoon', 'hT');
INSERT INTO unit_base VALUES (21, 'heap c', 'heaped cup', 'hc');
INSERT INTO unit_base VALUES (35, 'heaped tbs', 'heaped tablespoon', 'hT');
INSERT INTO unit_base VALUES (26, 'heaped dss', 'heaped dessertspoon', 'hD');
INSERT INTO unit_base VALUES (25, 'heaped dessertspoon', 'heaped dessertspoon', 'hD');
INSERT INTO unit_base VALUES (22, 'heaped dessert spoons', 'heaped dessertspoon', 'hD');
INSERT INTO unit_base VALUES (37, 'heaped tb', 'heaped tablespoon', 'hT');
INSERT INTO unit_base VALUES (17, 'heaping cup', 'heaped cup', 'hc');
INSERT INTO unit_base VALUES (31, 'heaped tablespoon', 'heaped tablespoon', 'hT');
INSERT INTO unit_base VALUES (32, 'heaping tbsp', 'heaped tablespoon', 'hT');
INSERT INTO unit_base VALUES (34, 'heaping tbs', 'heaped tablespoon', 'hT');
INSERT INTO unit_base VALUES (19, 'heaping c', 'heaped cup', 'hc');
INSERT INTO unit_base VALUES (43, 'heaped tsps', 'heaped teaspoon', 'ht');
INSERT INTO unit_base VALUES (45, 'heaped tsp', 'heaped teaspoon', 'ht');
INSERT INTO unit_base VALUES (30, 'heaping tablespoon', 'heaped tablespoon', 'hT');
INSERT INTO unit_base VALUES (47, 'heaped ts', 'heaped teaspoon', 'ht');
INSERT INTO unit_base VALUES (42, 'heaping tsps', 'heaped teaspoon', 'ht');
INSERT INTO unit_base VALUES (41, 'heaped teaspoon', 'heaped teaspoon', 'ht');
INSERT INTO unit_base VALUES (44, 'heaping tsp', 'heaped teaspoon', 'ht');
INSERT INTO unit_base VALUES (38, 'heaping teaspoons', 'heaped teaspoon', 'ht');
INSERT INTO unit_base VALUES (52, 'large bunch', 'large bunch', 'lB');
INSERT INTO unit_base VALUES (40, 'heaping teaspoon', 'heaped teaspoon', 'ht');
INSERT INTO unit_base VALUES (53, 'lg bunch', 'large bunch', 'lB');
INSERT INTO unit_base VALUES (61, 'lg can', 'large can', 'lc');
INSERT INTO unit_base VALUES (59, 'large cloves', 'large clove', 'lC');
INSERT INTO unit_base VALUES (54, 'large handful', 'large handful', 'lh');
INSERT INTO unit_base VALUES (55, 'large handfuls', 'large handful', 'lh');
INSERT INTO unit_base VALUES (60, 'lg cn', 'large can', 'lc');
INSERT INTO unit_base VALUES (56, 'lg handful', 'large handful', 'lh');
INSERT INTO unit_base VALUES (63, 'medium head', 'medium head', 'mH');
INSERT INTO unit_base VALUES (51, 'lg heads', 'large head', 'lH');
INSERT INTO unit_base VALUES (49, 'large heads', 'large head', 'lH');
INSERT INTO unit_base VALUES (50, 'lg head', 'large head', 'lH');
INSERT INTO unit_base VALUES (76, 'rounded ds', 'rounded dessertspoon', 'rd');
INSERT INTO unit_base VALUES (66, 'med heads', 'medium head', 'mH');
INSERT INTO unit_base VALUES (74, 'rounded dessertspoon', 'rounded dessertspoon', 'rd');
INSERT INTO unit_base VALUES (65, 'med head', 'medium head', 'mH');
INSERT INTO unit_base VALUES (70, 'round c', 'rounded cup', 'rc');
INSERT INTO unit_base VALUES (68, 'rounded cup', 'rounded cup', 'rc');
INSERT INTO unit_base VALUES (71, 'rounded dessert spoons', 'rounded dessertspoon', 'rd');
INSERT INTO unit_base VALUES (80, 'rounded tbsp', 'rounded tablespoon', 'rT');
INSERT INTO unit_base VALUES (75, 'rounded dss', 'rounded dessertspoon', 'rd');
INSERT INTO unit_base VALUES (81, 'rounded tbs', 'rounded tablespoon', 'rT');
INSERT INTO unit_base VALUES (77, 'rounded tablespoons', 'rounded tablespoon', 'rT');
INSERT INTO unit_base VALUES (78, 'rounded tablespoon', 'rounded tablespoon', 'rT');
INSERT INTO unit_base VALUES (86, 'rounded tsp', 'rounded teaspoon', 'rt');
INSERT INTO unit_base VALUES (87, 'rounded ts', 'rounded teaspoon', 'rt');
INSERT INTO unit_base VALUES (84, 'rounded teaspoon', 'rounded teaspoon', 'rt');
INSERT INTO unit_base VALUES (9, 'small can', 'small can', 'sc');
INSERT INTO unit_base VALUES (85, 'rounded tsps', 'rounded teaspoon', 'rt');
INSERT INTO unit_base VALUES (7, 'sm cn', 'small can', 'sc');
INSERT INTO unit_base VALUES (93, 'small handfuls', 'small handful', 'sH');
INSERT INTO unit_base VALUES (95, 'sm handfuls', 'small handful', 'sH');
INSERT INTO unit_base VALUES (94, 'sm handful', 'small handful', 'sH');
INSERT INTO unit_base VALUES (89, 'small heads', 'small head', 'th');
INSERT INTO unit_base VALUES (91, 'sm head', 'small head', 'th');
INSERT INTO unit_base VALUES (88, 'small head', 'small head', 'th');
INSERT INTO unit_base VALUES (339, 'ss', 'splash', 'ss');
INSERT INTO unit_base VALUES (399, 'co', 'container', 'co');
INSERT INTO unit_base VALUES (437, 'teaskanal', 'teaspoon', 'tk');
INSERT INTO unit_base VALUES (438, 'tsk', 'teaspoon', 'tk');
INSERT INTO unit_base VALUES (337, 'splashs', 'splash', 'ss');
INSERT INTO unit_base VALUES (336, 'splashes', 'splash', 'ss');
INSERT INTO unit_base VALUES (338, 'splash', 'splash', 'ss');
INSERT INTO unit_base VALUES (356, 'sr', 'strip', 'sr');
INSERT INTO unit_base VALUES (350, 'stick', 'stick', 'st');
INSERT INTO unit_base VALUES (384, 'tube', 'tube', 'tu');
INSERT INTO unit_base VALUES (439, 'blad', 'sheet', 'bl');
INSERT INTO unit_base VALUES (440, 'skivor', 'slice', 'sk');
INSERT INTO unit_base VALUES (441, 'msk', NULL, 'mk');
INSERT INTO unit_base VALUES (442, 'burk', 'jar', 'bk');
INSERT INTO unit_base VALUES (443, 'kaveskanal', NULL, 'kk');
INSERT INTO unit_base VALUES (444, 'squares', 'square', 'sq');
INSERT INTO unit_base VALUES (445, 'square', 'square', 'sq');
INSERT INTO unit_base VALUES (446, 'sq', 'square', 'sq');
INSERT INTO unit_base VALUES (447, 'small cans', 'small can', 'sc');
INSERT INTO unit_base VALUES (448, 'big pinch', 'large pinch', 'lp');
INSERT INTO unit_base VALUES (449, 'large pinch', 'large pinch', 'lp');
INSERT INTO unit_base VALUES (450, 'lp', 'large pinch', 'lp');
INSERT INTO unit_base VALUES (451, 'recipe', 'recipe', 'RC');
INSERT INTO unit_base VALUES (452, 'pkges', 'package', 'pk');
INSERT INTO unit_base VALUES (455, 'grains', 'grain', 'gn');
INSERT INTO unit_base VALUES (456, 'gn', 'grain', 'gn');
INSERT INTO unit_base VALUES (288, 'pkts', 'package', 'pk');
INSERT INTO unit_base VALUES (294, 'pkgs', 'package', 'pk');
INSERT INTO unit_base VALUES (297, 'pk', 'package', 'pk');
INSERT INTO unit_base VALUES (296, 'pkg', 'package', 'pk');
INSERT INTO unit_base VALUES (282, 'pn', 'pinch', 'pn');
INSERT INTO unit_base VALUES (279, 'pinches', 'pinch', 'pn');
INSERT INTO unit_base VALUES (187, 'drp', 'drop', 'dr');
INSERT INTO unit_base VALUES (280, 'pinchs', 'pinch', 'pn');
INSERT INTO unit_base VALUES (179, 'ds', 'dash', 'ds');
INSERT INTO unit_base VALUES (188, 'dr', 'drop', 'dr');
INSERT INTO unit_base VALUES (185, 'drop', 'drop', 'dr');
INSERT INTO unit_base VALUES (186, 'drps', 'drop', 'dr');
INSERT INTO unit_base VALUES (190, 'ea', 'each', 'ea');
INSERT INTO unit_base VALUES (165, 'dash', 'dash', 'ds');
INSERT INTO unit_base VALUES (334, 'slice', 'slice', 'sl');
INSERT INTO unit_base VALUES (333, 'slices', 'slice', 'sl');
INSERT INTO unit_base VALUES (189, 'each', 'each', 'ea');
INSERT INTO unit_base VALUES (283, 'pints', 'pint', 'pt');
INSERT INTO unit_base VALUES (202, 'floz', 'fluid ounce', 'fl');
INSERT INTO unit_base VALUES (286, 'pt.', 'pint', 'pt');
INSERT INTO unit_base VALUES (285, 'pts', 'pint', 'pt');
INSERT INTO unit_base VALUES (313, 'qts', 'quart', 'qt');
INSERT INTO unit_base VALUES (287, 'pt', 'pint', 'pt');
INSERT INTO unit_base VALUES (314, 'qt.', 'quart', 'qt');
INSERT INTO unit_base VALUES (205, 'galls', 'gallon', 'ga');
INSERT INTO unit_base VALUES (210, 'ga', 'gallon', 'ga');
INSERT INTO unit_base VALUES (311, 'quarts', 'quart', 'qt');
INSERT INTO unit_base VALUES (204, 'gallon', 'gallon', 'ga');
INSERT INTO unit_base VALUES (208, 'gal.', 'gallon', 'ga');
INSERT INTO unit_base VALUES (209, 'gal', 'gallon', 'ga');
INSERT INTO unit_base VALUES (271, 'oz.', 'ounce', 'oz');
INSERT INTO unit_base VALUES (270, 'ounce', 'ounce', 'oz');
INSERT INTO unit_base VALUES (207, 'gals', 'gallon', 'ga');
INSERT INTO unit_base VALUES (272, 'oz', 'ounce', 'oz');
INSERT INTO unit_base VALUES (269, 'ounces', 'ounce', 'oz');
INSERT INTO unit_base VALUES (305, 'lb.', 'pound', 'lb');
INSERT INTO unit_base VALUES (262, 'mls', 'milliliter', 'ml');
INSERT INTO unit_base VALUES (306, 'lb', 'pound', 'lb');
INSERT INTO unit_base VALUES (304, 'lbs', 'pound', 'lb');
INSERT INTO unit_base VALUES (303, 'pound', 'pound', 'lb');
INSERT INTO unit_base VALUES (263, 'milliliters', 'milliliter', 'ml');
INSERT INTO unit_base VALUES (265, 'milliliter', 'milliliter', 'ml');
INSERT INTO unit_base VALUES (174, 'd/ls', 'deciliter', 'dl');
INSERT INTO unit_base VALUES (173, 'd/l', 'deciliter', 'dl');
INSERT INTO unit_base VALUES (257, 'miligrams', 'milligram', 'mg');
INSERT INTO unit_base VALUES (170, 'decilitre', 'deciliter', 'dl');
INSERT INTO unit_base VALUES (169, 'deciliters', 'deciliter', 'dl');
INSERT INTO unit_base VALUES (247, 'l', 'litre', 'l');
INSERT INTO unit_base VALUES (168, 'decilitres', 'deciliter', 'dl');
INSERT INTO unit_base VALUES (242, 'liters', 'litre', 'l');
INSERT INTO unit_base VALUES (260, 'milligram', 'milligram', 'mg');
INSERT INTO unit_base VALUES (244, 'liter', 'litre', 'l');
INSERT INTO unit_base VALUES (243, 'litres', 'litre', 'l');
INSERT INTO unit_base VALUES (261, 'mg', 'milligram', 'mg');
INSERT INTO unit_base VALUES (214, 'g', 'gram', 'g');
INSERT INTO unit_base VALUES (258, 'milligrams', 'milligram', 'mg');
INSERT INTO unit_base VALUES (259, 'miligram', 'milligram', 'mg');
INSERT INTO unit_base VALUES (228, 'kgs', 'kilogram', 'kg');
INSERT INTO unit_base VALUES (213, 'gram', 'gram', 'g');
INSERT INTO unit_base VALUES (211, 'gms', 'gram', 'g');
INSERT INTO unit_base VALUES (212, 'grams', 'gram', 'g');
INSERT INTO unit_base VALUES (231, 'kg', 'kilogram', 'kg');
INSERT INTO unit_base VALUES (326, 'sm.', 'small', 'sm');
INSERT INTO unit_base VALUES (325, 'small', 'small', 'sm');
INSERT INTO unit_base VALUES (230, 'kilogram', 'kilogram', 'kg');
INSERT INTO unit_base VALUES (254, 'med', 'medium', 'md');
INSERT INTO unit_base VALUES (327, 'sm', 'small', 'sm');
INSERT INTO unit_base VALUES (252, 'medium', 'medium', 'md');
INSERT INTO unit_base VALUES (172, 'dl', 'deciliter', 'dl');
INSERT INTO unit_base VALUES (255, 'md', 'medium', 'md');
INSERT INTO unit_base VALUES (236, 'large', 'large', 'lg');
INSERT INTO unit_base VALUES (238, 'lg', 'large', 'lg');
INSERT INTO unit_base VALUES (175, 'dessertspoons', 'dessertspoon', 'd');
INSERT INTO unit_base VALUES (176, 'dessertspoon', 'dessertspoon', 'd');
INSERT INTO unit_base VALUES (167, 'dls', 'deciliter', 'dl');
INSERT INTO unit_base VALUES (181, 'dozen', 'dozen', 'dz');
INSERT INTO unit_base VALUES (180, 'dozens', 'dozen', 'dz');
INSERT INTO unit_base VALUES (191, 'ears', 'ear', 'er');
INSERT INTO unit_base VALUES (182, 'doz', 'dozen', 'dz');
INSERT INTO unit_base VALUES (178, 'dss', 'dessertspoon', 'd');
INSERT INTO unit_base VALUES (194, 'envelopes', 'envelope', 'en');
INSERT INTO unit_base VALUES (192, 'ear', 'ear', 'er');
INSERT INTO unit_base VALUES (198, 'fillets', 'fillet', 'ft');
INSERT INTO unit_base VALUES (193, 'er', 'ear', 'er');
INSERT INTO unit_base VALUES (196, 'ev', 'envelope', 'en');
INSERT INTO unit_base VALUES (197, 'en', 'envelope', 'en');
INSERT INTO unit_base VALUES (200, 'ft', 'fillet', 'ft');
INSERT INTO unit_base VALUES (215, 'handfuls', 'handful', 'hf');
INSERT INTO unit_base VALUES (217, 'hf', 'handful', 'hf');
INSERT INTO unit_base VALUES (218, 'heads', 'head', 'hd');
INSERT INTO unit_base VALUES (221, 'inches', 'inch', 'in');
INSERT INTO unit_base VALUES (223, 'inch', 'inch', 'in');
INSERT INTO unit_base VALUES (220, 'hd', 'head', 'hd');
INSERT INTO unit_base VALUES (224, 'in', 'inch', 'in');
INSERT INTO unit_base VALUES (225, 'jars', 'jar', 'jr');
INSERT INTO unit_base VALUES (222, 'inchs', 'inch', 'in');
INSERT INTO unit_base VALUES (234, 'knob', 'knob', 'kb');
INSERT INTO unit_base VALUES (227, 'jr', 'jar', 'jr');
INSERT INTO unit_base VALUES (301, 'pr', 'portion', 'pr');
INSERT INTO unit_base VALUES (233, 'knobs', 'knob', 'kb');
INSERT INTO unit_base VALUES (251, 'lf', 'leaf', 'lf');
INSERT INTO unit_base VALUES (239, 'leaf', 'leaf', 'lf');
INSERT INTO unit_base VALUES (240, 'leaves', 'leaf', 'lf');
INSERT INTO unit_base VALUES (250, 'lv', 'loaf', 'lv');
INSERT INTO unit_base VALUES (248, 'loaf', 'loaf', 'lv');
INSERT INTO unit_base VALUES (249, 'loaves', 'loaf', 'lv');
INSERT INTO unit_base VALUES (289, 'packets', 'package', 'pk');
INSERT INTO unit_base VALUES (291, 'packet', 'package', 'pk');
INSERT INTO unit_base VALUES (298, 'packages', 'package', 'pk');
INSERT INTO unit_base VALUES (292, 'package', 'package', 'pk');
INSERT INTO unit_base VALUES (171, 'deciliter', 'deciliter', 'dl');
INSERT INTO unit_base VALUES (245, 'litre', 'litre', 'l');
INSERT INTO unit_base VALUES (97, 'bag', 'bag', 'bg');
INSERT INTO unit_base VALUES (307, '#', 'pound', 'lb');
INSERT INTO unit_base VALUES (99, 'balls', 'ball', 'bl');
INSERT INTO unit_base VALUES (102, 'bars', 'bar', 'br');
INSERT INTO unit_base VALUES (389, 'bk', 'block', 'bk');
INSERT INTO unit_base VALUES (105, 'block', 'block', 'bk');
INSERT INTO unit_base VALUES (388, 'whole', 'whole', 'wh');
INSERT INTO unit_base VALUES (386, 'unit', 'container', 'co');
INSERT INTO unit_base VALUES (264, 'millilitres', 'milliliter', 'ml');
INSERT INTO unit_base VALUES (290, 'pkt', 'package', 'pk');
INSERT INTO unit_base VALUES (295, 'pkg.', 'package', 'pk');
INSERT INTO unit_base VALUES (281, 'pinch', 'pinch', 'pn');
INSERT INTO unit_base VALUES (184, 'drops', 'drop', 'dr');
INSERT INTO unit_base VALUES (164, 'dashs', 'dash', 'ds');
INSERT INTO unit_base VALUES (131, 'cartons', 'carton', 'ct');
INSERT INTO unit_base VALUES (120, 'bunches', 'bunch', 'bn');
INSERT INTO unit_base VALUES (335, 'sl', 'slice', 'sl');
INSERT INTO unit_base VALUES (29, 'heaped tablespoons', 'heaped tablespoon', 'hT');
INSERT INTO unit_base VALUES (256, 'mgs', 'milligram', 'mg');
INSERT INTO unit_base VALUES (136, 'cgs', 'centigram', 'cg');
INSERT INTO unit_base VALUES (139, 'cg', 'centigram', 'cg');
INSERT INTO unit_base VALUES (229, 'kilograms', 'kilogram', 'kg');
INSERT INTO unit_base VALUES (232, 'kilo', 'kilogram', 'kg');
INSERT INTO unit_base VALUES (253, 'med.', 'medium', 'md');
INSERT INTO unit_base VALUES (237, 'lg.', 'large', 'lg');
INSERT INTO unit_base VALUES (390, 'decigram', 'decigram', 'dg');
INSERT INTO unit_base VALUES (391, 'cubic centimeter', 'milliliter', 'cc');
INSERT INTO unit_base VALUES (378, 't', 'teaspoon', 'ts');
INSERT INTO unit_base VALUES (372, 'teaspoon', 'teaspoon', 'ts');
INSERT INTO unit_base VALUES (373, 'tsps', 'teaspoon', 'ts');
INSERT INTO unit_base VALUES (374, 'tsp.', 'teaspoon', 'ts');
INSERT INTO unit_base VALUES (375, 'tsp', 'teaspoon', 'ts');
INSERT INTO unit_base VALUES (376, 'ts', 'teaspoon', 'ts');
INSERT INTO unit_base VALUES (371, 'teaspoons', 'teaspoon', 'ts');
INSERT INTO unit_base VALUES (365, 'T', 'tablespoon', 'tb');
INSERT INTO unit_base VALUES (377, 't.', 'teaspoon', 'ts');
INSERT INTO unit_base VALUES (392, 'cc', 'milliliter', 'cc');
INSERT INTO unit_base VALUES (15, 'heaping cups', 'heaped cup', 'hc');
INSERT INTO unit_base VALUES (119, 'bb', 'bulb', 'bb');
INSERT INTO unit_base VALUES (110, 'btl', 'bottle', 'bt');
INSERT INTO unit_base VALUES (114, 'bx', 'box', 'bx');
INSERT INTO unit_base VALUES (36, 'heaping tb', 'heaped tablespoon', 'hT');
INSERT INTO unit_base VALUES (380, 'c.c', 'teaspoon', 'ts');
INSERT INTO unit_base VALUES (379, 'c.c.', 'teaspoon', 'ts');
INSERT INTO unit_base VALUES (364, 'c.s', 'tablespoon', 'tb');
INSERT INTO unit_base VALUES (359, 'tbsp.', 'tablespoon', 'tb');
INSERT INTO unit_base VALUES (360, 'tbsp', 'tablespoon', 'tb');
INSERT INTO unit_base VALUES (369, 'tbsn', 'tablespoon', 'tb');
INSERT INTO unit_base VALUES (361, 'tbs.', 'tablespoon', 'tb');
INSERT INTO unit_base VALUES (362, 'tbs', 'tablespoon', 'tb');
INSERT INTO unit_base VALUES (368, 'tblsp', 'tablespoon', 'tb');
INSERT INTO unit_base VALUES (363, 'tb', 'tablespoon', 'tb');
INSERT INTO unit_base VALUES (367, 'tabs', 'tablespoon', 'tb');
INSERT INTO unit_base VALUES (357, 'tablespoons', 'tablespoon', 'tb');
INSERT INTO unit_base VALUES (358, 'tablespoon', 'tablespoon', 'tb');
INSERT INTO unit_base VALUES (366, 'tab', 'tablespoon', 'tb');
INSERT INTO unit_base VALUES (4, 'fluid ounces', 'fluid ounce', 'fl');
INSERT INTO unit_base VALUES (2, 'fl ozs', 'fluid ounce', 'fl');
INSERT INTO unit_base VALUES (201, 'fl', 'fluid ounce', 'fl');
INSERT INTO unit_base VALUES (284, 'pint', 'pint', 'pt');
INSERT INTO unit_base VALUES (315, 'qt', 'quart', 'qt');
INSERT INTO unit_base VALUES (312, 'quart', 'quart', 'qt');
INSERT INTO unit_base VALUES (203, 'gallons', 'gallon', 'ga');
INSERT INTO unit_base VALUES (206, 'gall', 'gallon', 'ga');
INSERT INTO unit_base VALUES (268, 'ozs', 'ounce', 'oz');
INSERT INTO unit_base VALUES (302, 'pounds', 'pound', 'lb');
INSERT INTO unit_base VALUES (267, 'ml', 'milliliter', 'ml');
INSERT INTO unit_base VALUES (266, 'millilitre', 'milliliter', 'ml');
INSERT INTO unit_base VALUES (148, 'c/l', 'centiliter', 'cl');
INSERT INTO unit_base VALUES (127, 'capful', 'capful', 'cf');
INSERT INTO unit_base VALUES (128, 'capfuls', 'capful', 'cf');
INSERT INTO unit_base VALUES (393, 'cf', 'capful', 'cf');
INSERT INTO unit_base VALUES (145, 'centilitre', 'centiliter', 'cl');
INSERT INTO unit_base VALUES (146, 'centiliter', 'centiliter', 'cl');
INSERT INTO unit_base VALUES (150, 'cms', 'centimeter', 'cm');
INSERT INTO unit_base VALUES (14, 'dessert sp', 'dessertspoon', 'd');
INSERT INTO unit_base VALUES (177, 'dessertsp', 'dessertspoon', 'd');
INSERT INTO unit_base VALUES (381, 'tl', 'teaspoon', 'tl');
INSERT INTO unit_base VALUES (183, 'dz', 'dozen', 'dz');
INSERT INTO unit_base VALUES (195, 'envelope', 'envelope', 'en');
INSERT INTO unit_base VALUES (199, 'fillet', 'fillet', 'ft');
INSERT INTO unit_base VALUES (216, 'handful', 'handful', 'hf');
INSERT INTO unit_base VALUES (219, 'head', 'head', 'hd');
INSERT INTO unit_base VALUES (16, 'heaped cups', 'heaped cup', 'hc');
INSERT INTO unit_base VALUES (23, 'heaped dessert spoon', 'heaped dessertspoon', 'hD');
INSERT INTO unit_base VALUES (27, 'heaped ds', 'heaped dessertspoon', 'hD');
INSERT INTO unit_base VALUES (24, 'heaped dessertspoons', 'heaped dessertspoon', 'hD');
INSERT INTO unit_base VALUES (28, 'heaping tablespoons', 'heaped tablespoon', 'hT');
INSERT INTO unit_base VALUES (39, 'heaped teaspoons', 'heaped teaspoon', 'ht');
INSERT INTO unit_base VALUES (46, 'heaping ts', 'heaped teaspoon', 'ht');
INSERT INTO unit_base VALUES (226, 'jar', 'jar', 'jr');
INSERT INTO unit_base VALUES (235, 'kb', 'knob', 'kb');
INSERT INTO unit_base VALUES (62, 'large can', 'large can', 'lc');
INSERT INTO unit_base VALUES (58, 'large clove', 'large clove', 'lC');
INSERT INTO unit_base VALUES (57, 'lg handfuls', 'large handful', 'lh');
INSERT INTO unit_base VALUES (48, 'large head', 'large head', 'lH');
INSERT INTO unit_base VALUES (64, 'medium heads', 'medium head', 'mH');
INSERT INTO unit_base VALUES (293, 'pack', 'package', 'pk');
INSERT INTO unit_base VALUES (273, 'part', 'part', 'pT');
INSERT INTO unit_base VALUES (274, 'parts', 'part', 'pT');
INSERT INTO unit_base VALUES (394, 'mH', 'medium head', 'mH');
INSERT INTO unit_base VALUES (395, 'pT', 'part', 'pT');
INSERT INTO unit_base VALUES (278, 'pc', 'piece', 'pc');
INSERT INTO unit_base VALUES (275, 'pieces', 'piece', 'pc');
INSERT INTO unit_base VALUES (276, 'piece', 'piece', 'pc');
INSERT INTO unit_base VALUES (277, 'pcs', 'piece', 'pc');
INSERT INTO unit_base VALUES (300, 'portion', 'portion', 'pr');
INSERT INTO unit_base VALUES (299, 'portions', 'portion', 'pr');
INSERT INTO unit_base VALUES (310, 'pu', 'punnet', 'pu');
INSERT INTO unit_base VALUES (308, 'punnets', 'punnet', 'pu');
INSERT INTO unit_base VALUES (309, 'punnet', 'punnet', 'pu');
INSERT INTO unit_base VALUES (318, 'rs', 'rasher', 'rs');
INSERT INTO unit_base VALUES (317, 'rasher', 'rasher', 'rs');
INSERT INTO unit_base VALUES (316, 'rashers', 'rasher', 'rs');
INSERT INTO unit_base VALUES (319, 'ribs', 'rib', 'rb');
INSERT INTO unit_base VALUES (320, 'rib', 'rib', 'rb');
INSERT INTO unit_base VALUES (321, 'rb', 'rib', 'rb');
INSERT INTO unit_base VALUES (355, 'str', 'strip', 'sr');
INSERT INTO unit_base VALUES (348, 'sk', 'stalk', 'sk');
INSERT INTO unit_base VALUES (346, 'stalk', 'stalk', 'sk');
INSERT INTO unit_base VALUES (354, 'strip', 'strip', 'sr');
INSERT INTO unit_base VALUES (351, 'stk', 'stick', 'st');
INSERT INTO unit_base VALUES (353, 'strips', 'strip', 'sr');
INSERT INTO unit_base VALUES (347, 'stlk', 'stalk', 'sk');
INSERT INTO unit_base VALUES (349, 'sticks', 'stick', 'st');
INSERT INTO unit_base VALUES (387, 'un', 'unit', 'un');
INSERT INTO unit_base VALUES (352, 'st', 'stick', 'st');
INSERT INTO unit_base VALUES (383, 'tubes', 'tube', 'tu');
INSERT INTO unit_base VALUES (400, 'bc', 'branch', 'bc');
INSERT INTO unit_base VALUES (385, 'tu', 'tube', 'tu');
INSERT INTO unit_base VALUES (382, 'tub', 'container', 'co');
INSERT INTO unit_base VALUES (67, 'rounded cups', 'rounded cup', 'rc');
INSERT INTO unit_base VALUES (69, 'rounded c', 'rounded cup', 'rc');
INSERT INTO unit_base VALUES (396, 'rc', 'rounded cup', 'rc');
INSERT INTO unit_base VALUES (330, 'sb', 'slab', 'sb');
INSERT INTO unit_base VALUES (328, 'slabs', 'slab', 'sb');
INSERT INTO unit_base VALUES (329, 'slab', 'slab', 'sb');
INSERT INTO unit_base VALUES (73, 'rounded dessertspoons', 'rounded dessertspoon', 'rd');
INSERT INTO unit_base VALUES (72, 'rounded dessert spoon', 'rounded dessertspoon', 'rd');
INSERT INTO unit_base VALUES (79, 'rounded tbsps', 'rounded tablespoon', 'rT');
INSERT INTO unit_base VALUES (82, 'rounded tb', 'rounded tablespoon', 'rT');
INSERT INTO unit_base VALUES (83, 'rounded teaspoons', 'rounded teaspoon', 'rt');
INSERT INTO unit_base VALUES (322, 'sheets', 'sheet', 'sh');
INSERT INTO unit_base VALUES (323, 'sheet', 'sheet', 'sh');
INSERT INTO unit_base VALUES (324, 'sh', 'sheet', 'sh');
INSERT INTO unit_base VALUES (345, 'stalks', 'stalk', 'sk');
INSERT INTO unit_base VALUES (331, 'sleeve', 'sleeve', 'sv');
INSERT INTO unit_base VALUES (332, 'sleeves', 'sleeve', 'sv');
INSERT INTO unit_base VALUES (397, 'sv', 'sleeve', 'sv');
INSERT INTO unit_base VALUES (8, 'sm can', 'small can', 'sc');
INSERT INTO unit_base VALUES (92, 'small handful', 'small handful', 'sH');
INSERT INTO unit_base VALUES (90, 'sm heads', 'small head', 'th');
INSERT INTO unit_base VALUES (398, 'th', 'small head', 'th');
INSERT INTO unit_base VALUES (340, 'sprigs', 'sprig', 'sp');
INSERT INTO unit_base VALUES (341, 'sprig', 'sprig', 'sp');
INSERT INTO unit_base VALUES (342, 'sprg', 'sprig', 'sp');
INSERT INTO unit_base VALUES (343, 'spr', 'sprig', 'sp');
INSERT INTO unit_base VALUES (344, 'sp', 'sprig', 'sp');
INSERT INTO unit_base VALUES (401, 'bl', 'ball', 'bl');
INSERT INTO unit_base VALUES (402, 'br', 'bar', 'br');
INSERT INTO unit_base VALUES (403, 'bs', 'basket', 'bs');
INSERT INTO unit_base VALUES (404, 'cv', 'clove', 'cv');
INSERT INTO unit_base VALUES (405, 'd', 'dessertspoon', 'd');
INSERT INTO unit_base VALUES (406, 'lc', 'large can', 'lc');
INSERT INTO unit_base VALUES (407, 'lh', 'large handful', 'lh');
INSERT INTO unit_base VALUES (408, 'lH', 'large head', 'lH');
INSERT INTO unit_base VALUES (409, 'rd', 'rounded dessertspoon', 'rd');
INSERT INTO unit_base VALUES (410, 'rt', 'rounded teaspoon', 'rt');
INSERT INTO unit_base VALUES (411, 'rT', 'rounded tablespoon', 'rT');
INSERT INTO unit_base VALUES (412, 'sc', 'small can', 'sc');
INSERT INTO unit_base VALUES (413, 'sH', 'small handful', 'sH');
INSERT INTO unit_base VALUES (416, 'dg', 'decigram', 'dg');
INSERT INTO unit_base VALUES (417, 'xl', 'extra large', 'xl');
INSERT INTO unit_base VALUES (11, 'extra large', 'extra large', 'xl');
INSERT INTO unit_base VALUES (418, 'hc', 'heaped cup', 'hc');
INSERT INTO unit_base VALUES (419, 'hD', 'heaped dessertspoon', 'hD');
INSERT INTO unit_base VALUES (420, 'ht', 'heaped teaspoon', 'ht');
INSERT INTO unit_base VALUES (421, 'hT', 'heaped tablespoon', 'hT');
INSERT INTO unit_base VALUES (422, 'lB', 'large bunch', 'lB');
INSERT INTO unit_base VALUES (424, 'tin', 'tin', 'tn');
INSERT INTO unit_base VALUES (425, 'tn', 'tin', 'tn');
INSERT INTO unit_base VALUES (426, 'ms', 'pinch', 'ms');
INSERT INTO unit_base VALUES (370, 'el', 'tablespoon', 'el');
INSERT INTO unit_base VALUES (427, 'shot', 'shot', 'SH');
INSERT INTO unit_base VALUES (428, 'nagy fej', 'deciliter', 'nf');
INSERT INTO unit_base VALUES (429, 'gerezd', 'clove', 'gr');
INSERT INTO unit_base VALUES (423, 'gr', 'gram', 'g');
INSERT INTO unit_base VALUES (430, 'csipet', 'pinch', 'cs');
INSERT INTO unit_base VALUES (431, 'evokanal', 'tablespoon', 'ek');
INSERT INTO unit_base VALUES (433, 'cs', 'pinch', 'cs');
INSERT INTO unit_base VALUES (434, 'ek', 'tablespoon', 'ek');
INSERT INTO unit_base VALUES (435, 'tk', 'teaspoon', 'tk');
INSERT INTO unit_base VALUES (432, 'teáskanál', 'teaspoon', 'tk');
INSERT INTO unit_base VALUES (436, 'teakanal', 'teaspoon', 'tk');
INSERT INTO unit_base VALUES (457, 'flavors', 'flavour', 'fv');
INSERT INTO unit_base VALUES (459, 'glasses', 'glass', 'gl');
INSERT INTO unit_base VALUES (460, 'glass', 'glass', 'gl');
INSERT INTO unit_base VALUES (461, 'gl', 'glass', 'gl');
INSERT INTO unit_base VALUES (462, 'doboz', 'box', 'bx');
INSERT INTO unit_base VALUES (464, 'small bunch', 'small bunch', 'sB');
INSERT INTO unit_base VALUES (463, 'generous sprinkles', 'generous sprinkle', 'gs');
INSERT INTO unit_base VALUES (465, 'lingura', 'spoon', 'ln');
INSERT INTO unit_base VALUES (466, 'linguri', 'spoon', 'ln');
INSERT INTO unit_base VALUES (467, 'lingurita', 'teaspoon', 'lt');
INSERT INTO unit_base VALUES (468, 'legatura', 'bunch', 'le');
INSERT INTO unit_base VALUES (469, 'portie', 'portion', 'pr');
INSERT INTO unit_base VALUES (470, 'roll', 'roll', 'rl');
INSERT INTO unit_base VALUES (471, 'rl', 'roll', 'rl');
INSERT INTO unit_base VALUES (473, 'shake', 'shake', 'se');
INSERT INTO unit_base VALUES (472, 'shakes', 'shake', 'se');
INSERT INTO unit_base VALUES (474, 'tubs', 'container', 'co');
INSERT INTO unit_base VALUES (475, 'rack', 'rack', 'rk');
INSERT INTO unit_base VALUES (476, 'rk', 'rack', 'rk');
INSERT INTO unit_base VALUES (477, 'tins', 'tin', 'tn');
INSERT INTO unit_base VALUES (478, 'packaged', 'package', 'pk');
INSERT INTO unit_base VALUES (480, 'large cans', 'large can', 'lc');
INSERT INTO unit_base VALUES (479, 'big cans', 'large can', 'lc');

SELECT pg_catalog.setval('unit_base_id_seq', 480, true);

ALTER TABLE ONLY unit_base
    ADD CONSTRAINT unit_base_pkey PRIMARY KEY (id);

ALTER TABLE ONLY unit_base
    ADD CONSTRAINT unit_base_unit_key UNIQUE (unit);

CREATE TABLE email_history
(
  email text,
  owner bigint,
  id bigserial NOT NULL,
  name text,
  CONSTRAINT email_history_pkey PRIMARY KEY (id),
  CONSTRAINT email_history_owner_fkey FOREIGN KEY (owner)
      REFERENCES owner (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);

CREATE OR REPLACE FUNCTION query_delete_unused()
  RETURNS void AS
$BODY$delete from category_owner where category not in(select distinct cat from recipe_cat_subcat where cat is not null) and id!=20;

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

delete from preprep where id not in(select distinct preprep1 from recipe_ing where preprep1 is not null union select distinct preprep2 from recipe_ing where preprep2 is not null);$BODY$
  LANGUAGE sql VOLATILE
  COST 100;
  
ALTER TABLE menu_recipe ADD meal TEXT;
DROP FUNCTION query_add_menu_recipe(bigint, text, bigint, integer, integer);
DROP FUNCTION query_menu(bigint);
ALTER TABLE owner ADD popovers BOOLEAN DEFAULT true;
UPDATE owner SET popovers=true;
DROP FUNCTION query_user_prefs(bigint);

CREATE OR REPLACE FUNCTION query_user_prefs(IN bigint, OUT boolean, OUT boolean, OUT bigint, OUT bigint, OUT text, OUT bigint, OUT character, OUT boolean, OUT boolean, OUT bigint, OUT bigint, OUT bigint, OUT bigint, OUT boolean)
  RETURNS SETOF record AS
'select toc, catt, datefmt,measure,ebtitle,paper,get_measure(measure) as msname, pdf, rapp, numfmt, fracdec, region, groroz, popovers from owner where id=$1'
  LANGUAGE sql VOLATILE
  COST 100
  ROWS 1000;
  
CREATE OR REPLACE FUNCTION query_recipe_cats(IN bigint, OUT character, OUT character)
  RETURNS SETOF record AS
'SELECT get_category(cat) as category, get_subcategory(subcat) as subcategory FROM recipe_cat_subcat WHERE recipe = $1 order by subcat'
  LANGUAGE sql VOLATILE
  COST 100
  ROWS 1000;
--
-- PostgreSQL database dump complete
--

