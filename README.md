# Movie Night Trivia

### Movie Night Trivia parameters
* two players allowed on separate devices
* random movie from imdb top 250
* guess the year the selected movie comes from
* +5 for correct answer, -3 for incorrect
* Max 8 rounds
* To scrape from the following URI - http://www.imdb.com/chart/top?ref_=nb_mv_3_chttp

### Local testing

```
# Add 127.0.0.1 movie-trivia.noondaysun.org to hosts file
# Eg. echo "127.0.0.1 movie-trivia.noondaysun.org movie-trivia" | tee -a /etc/hosts
docker-compose up -d --build --force-recreate; docker-compose logs -f

open http://movie-trivia.noondaysun.org

# Tests et cetera
docker-compose exec php74 sh -c "composer lint; composer sniffs; composer stan; composer test"
```
