# Small Project to Display Git Commit History
The project dislays recent 25 commits of nodeJS respository.

The [backend work](https://github.com/hammad-gujar/gitCommitsHistory/tree/commitHistory_backEndWork) is developed on Laravel framework. Below are the details.
- A scheduler job which periodically runs and sync the commits history in database.
- A model to store the data related to history of the commits.
- Model also contains the functions consist of REST call to github which sync the data in database.
- Model also has function which return the data to frontend.

The [frontend](https://github.com/hammad-gujar/gitCommitsHistory/tree/commitHistory_frontEndWork) part is developed on Angular framework. Below are the details.
- Angular Material is used to desiging the UI.
- A service to communicate with backend.
- App component to display the data of commits history.
- A table to display the author name, date of commit, and commit hash.
- Table data can be filtered by clicking the author name. It will display only the commits of clicked author name.

# Build and Deployement
Both frontend and backend are developed on localhost.
- In the [frontend env file](https://github.com/hammad-gujar/gitCommitsHistory/blob/commitHistory_frontEndWork/commitHistoryFrontend/src/environments/environment.ts), set the `serverAppURL` according to your backend instance.
- In the backend, create the mysql database named `commithistorybackend` and provide the database credentials in [backend env file](https://github.com/hammad-gujar/gitCommitsHistory/blob/commitHistory_frontEndWork/commitHistoryFrontend/src/environments/environment.ts) and run the [migration file](https://github.com/hammad-gujar/gitCommitsHistory/blob/commitHistory_backEndWork/commitHistoryBackend/database/migrations/2021_10_30_203827_create_commit_histories_table.php)  to create the table for storing the commits data.
- The cron setup is also required to run the scheduler job.


