# Professional Blog in PHP

This project is a professional blog developed in PHP, designed to showcase your skills and expertise in web development. The blog is built to provide a smooth user experience for both visitors and administrators.

## Features

The blog consists of two main parts:

1. **Pages Accessible to All Visitors:**
   - Home page presenting your professional identity, a navigation menu, a contact form, and links to your social media profiles.
   - Page listing all blog posts, including their titles, dates of last modification, summaries, and links to the full articles.
   - Page detailing a specific blog post, displaying the title, summary, content, author, last update date, as well as the ability to add comments and the list of validated and published comments.
   - Page allowing to modify a blog post, with the possibility to edit the title, summary, author, and content.

2. **Administration Pages:**
   - Accessible only to registered and validated users.
   - Allow management of blog posts, including addition, modification, and deletion.
   - Control access based on user rights, with restriction to administrators only for management operations.

## Technologies Used

This project uses PHP with the Composer dependency manager for integrating PHPMailer.

## Installation

1. Clone the repository from GitHub.
2. Install dependencies with Composer:

```bash
composer install
```

3. Configure database access parameters in the `.env` file.
4. Configuration of the BASE_URL before getting started with using the application, make sure to configure the base URL in the config.php file. This URL is used to construct the absolute links of your application. For example, if your application is hosted on http://example.com/, you should define the base URL as follows:
```bash
define('BASE_URL', "http://example.com/");
```
Make sure to replace http://example.com/ with the actual URL of your application. It's important to properly configure this URL to ensure the correct functioning of links and redirects in your application.

## Usage

- Access the site via a web browser.
- Navigate between different pages using the navigation menu.
- To access the administration part, click on the link in the footer menu and log in with the appropriate credentials.

## Security

This project has been developed following the best web security practices to avoid vulnerabilities such as XSS, CSRF, SQL Injection, session hijacking, and possible PHP script uploads. Security tests have been conducted to ensure the robustness of the application.

## Contributions

Contributions are welcome! If you wish to contribute to this project, please open an issue to discuss the proposed changes.

## License

This project is licensed under the MIT License.
