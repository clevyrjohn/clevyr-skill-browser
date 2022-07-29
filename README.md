# Clevyr Skill Browser

### How to make it work:

You'll need (1) Docker Desktop running, (2) access to Anne S's Clevyr Skill Inventory spreadsheet, and a (3) Google API service account with the Google Sheets & Google Drive APIs enabled. 

After setting up your service account, download the credentials JSON file and place it in the `/storage` folder.

With that done, clone this repository and copy `.env.example` to `.env` then configure that last four lines of `.env` with your Google API variables.

In your terminal, `cd` into the repository's root directory. Then type:

```
source .zshrc
init
sail up -d
sail npm install
sail artisan key:generate
sail artisan migrate
sail npm run dev
```

The browser should be available at http://clevyr-skill-browser.test

To import data, go to http://clevyr-skill-browser.test/import . If everything looks good, click "Import!" and wait about 10-15 seconds.

You should now be able to browse the data contained in Anne's spreadsheet.
