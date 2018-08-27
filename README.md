# EMF Medical Stats

This repository:

- processes the ePRFs pulled from the First Aid nooks.
- combines those ePRFs into a flatfile database, with personal data removed

Eventually, it will also:

- allow us to categorise the ePRFs
- produce statistics

## Usage

*You must have PHP7+ and Composer installed*

Download the repo and install all the dependencies by opening a command prompt to the repo and running:

```
composer install
```

Each event will have the following folder structure

```
EMF20XX
|
├── combined
├── nooks
|   ├── nook1
|   ├── nook2
|   ├── nook3
|   ├── ...
|   ├── nookN
├── stats-data
```

### Getting the form data

When pulling the forms using `get-forms.sh` (not in this repo), pull the forms from each Nook into their corresponding folder.  `get-forms.sh` deposits the encrypted PRF along with a decrypted version of it.

Once all the Nooks have been pulled, run the `process-pull.php` script contained in this repo:

```
php process-pull.php --input /path/to/EMF20XX
```

This will move all the encrypted forms into `combined`, and create a flatfile database in `stats-data` of PRF objects for later use. These should not contain any personal data, but may need further anonimisation at the next step if the First Aider has included names in the free-text fields.

### Categorising the PRFs

Once the form data has been pulled, the PRFs should be categorised for the stats display.  This is a manual process.

Open a command prompt to this repo and start a web server:

```
php -S localhost:8000
```

then open `http:\\localhost:8000` in a browser window.

This will display the PRFs one by one and ask you to set: Category, Severity and RIDDOR. If there is only one severity for the category selected, this is automatically selected for you.