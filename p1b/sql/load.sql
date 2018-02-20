-- This is known as bulk loading data

-- loading movie.del
LOAD DATA LOCAL INFILE '~/data/movie.del' INTO TABLE Movie
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

-- loading actor.del
LOAD DATA LOCAL INFILE '~/data/actor1.del' INTO TABLE Actor
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE '~/data/actor2.del' INTO TABLE Actor
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE '~/data/actor3.del' INTO TABLE Actor
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

-- loading sales.del
LOAD DATA LOCAL INFILE '~/data/sales.del' INTO TABLE Sales
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

-- loading director.del
LOAD DATA LOCAL INFILE '~/data/director.del' INTO TABLE Director
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

-- loading moviegenre.del
LOAD DATA LOCAL INFILE '~/data/moviegenre.del' INTO TABLE MovieGenre
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

-- loading moviedirector.del
LOAD DATA LOCAL INFILE '~/data/moviedirector.del' INTO TABLE MovieDirector
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

-- loading movieactor.del
LOAD DATA LOCAL INFILE '~/data/movieactor1.del' INTO TABLE MovieActor
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE '~/data/movieactor2.del' INTO TABLE MovieActor
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

-- loading movierating.del
LOAD DATA LOCAL INFILE '~/data/movierating.del' INTO TABLE MovieRating
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

-- inserting initial values to MaxPersonID and MaxMovieID
INSERT INTO MaxPersonID VALUES(69000);
INSERT INTO MaxMovieID VALUES(4750);
