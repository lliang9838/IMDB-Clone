-- Movie(id, title, year, raiting, company)
create table Movie(
    id int,             -- Movie ID
    title varchar(100), -- Movie title
    year int,           -- Release year
    rating varchar(10), -- MPAA rating
    company varchar(50),-- Production company
    PRIMARY KEY(id)     -- Every movie must have a unique ID
) ENGINE=INNODB;

-- Actor(id, last, first, sex, dob, dod)
create table Actor(
    id int,             -- Actor ID
    last varchar(20),   -- Last name
    first varchar(20),  -- First name
    sex varchar(6),     -- Sex of the actor
    dob date,           -- Date of birth
    dod date,           -- Date of death
    PRIMARY KEY(id),    -- Every actor/actress must have a unique ID
    CHECK (sex = 'Female' OR sex = 'MALE') -- Sex should be male or female
) ENGINE=INNODB;

-- Sales(mid, ticketsSold, totalIncome)
create table Sales(
    mid int,            -- Movie ID
    ticketsSold int,    -- number of tickets sold
    totalIncome int,    -- total income in US dollars
    FOREIGN KEY(mid) REFERENCES Movie(id) -- Every sale must be associated with an existing movie
) ENGINE=INNODB;

-- Director(id, last, first, dob, dod)
create table Director(
    id int,             -- Director ID
    last varchar(20),   -- Last name
    first varchar(20),  -- First name
    dob Date,           -- Date of birth
    dod Date,           -- Date of death
    PRIMARY KEY(id)     -- Every director must have a unique ID
) ENGINE=INNODB;

-- MovieGenre(mid, genre)
create table MovieGenre(
    mid int,            -- Movie ID
    genre varchar(20),  -- Movie genre
    FOREIGN KEY(mid) REFERENCES Movie(id) -- Every movie genre must be referenced to an existing movie
) ENGINE=INNODB;

-- MovieDirector(mid, did)
create table MovieDirector(
    mid int,            -- Movie ID
    did int,            -- Director ID
    FOREIGN KEY(mid) REFERENCES Movie(id) -- Every director must be assciated with a movie that he/she directed
) ENGINE=INNODB;

-- MovieActor(mid, aid, role)
create table MovieActor(
    mid int,            -- Movie ID
    aid int,            -- Actor ID
    role varchar(50),   -- Actor role in movie
    FOREIGN KEY(mid) REFERENCES Movie(id), -- Every movie-actor pair must be referenced to an existing movie
    FOREIGN KEY(aid) REFERENCES Actor(id)  -- Every movie-actor pair must be referenced to an existing actor
) ENGINE=INNODB;

-- MovieRating(mid, imdb, rot)
create table MovieRating(
    mid int,            -- Movie ID
    imdb int,           -- IMDb rating
    rot int,            -- Rotten Tomatoes rating
    FOREIGN KEY(mid) REFERENCES Movie(id), -- Every movie rating must be associated with an existing movie
    CHECK(rot >= 0 AND rot <= 100)         -- Rating should be between 0 and 100 inclusive
) ENGINE=INNODB;

-- Review(name, time, mid, rating, comment)
create table Review(
    name varchar(20),   -- Reviewer name
    time timestamp,     -- Review time
    mid int,            -- Movie ID
    rating int,         -- Review rating
    comment varchar(50),-- Reviewer comment
    FOREIGN KEY(mid) REFERENCES Movie(id), -- Every movie review must be associated with an existing movie
    CHECK(rating >= 0 AND rating <= 5)     -- Rating should be between 0 and 5 inclusive
) ENGINE=INNODB;

-- MaxPersonID(id)
create table MaxPersonID(
    id int              -- Max ID assigned to all persons
) ENGINE=INNODB;

-- MaxMovieID(id)
create table MaxMovieID(
    id int              -- Max ID assigned to all movies
) ENGINE=INNODB;
