# CTRLFreaks Restaurant Webpage

https://voleksiyenko.greenriverdev.com/328/CTRLFreaks/home


This project is a full-stack restaurant web application developed using the Fat-Free Framework. 
It implements an MVC architecture, separating business logic and database interactions for clarity and 
maintainability. The project meets various requirements, ensuring robust functionality and clean, maintainable code.

# Project Requirements and How They Were Met

# ---------------

# Separates All Database/Business Logic Using the MVC Pattern 

The project adheres to the MVC (Model-View-Controller) pattern, ensuring a clear separation of concerns:

1. Model: Contains the business logic and database interactions, encapsulated in classes like DataLayer.

2. View: Templating is handled using Fat-Free Framework's Template class, rendering HTML views.

3. Controller: The Controller class manages application flow, handling requests, and coordinating between the model and view.

# Routes All URLs and Leverages a Templating Language Using the Fat-Free Framework
   Fat-Free Framework is used to manage routing and templating:

1. Routing: All URLs are routed through Fat-Free's routing mechanism defined in the index.php file.

2. Templating: The Template class is used to render views, ensuring a clean separation between logic and presentation.

# Clearly Defined Database Layer Using PDO and Prepared Statements
   The project includes a well-defined database layer that uses PDO and prepared statements for secure database interactions:

1. PDO: Database operations are encapsulated within the DataLayer class, using PDO for database connections.
2. Prepared Statements: All SQL queries use prepared statements to prevent SQL injection and ensure secure data handling.

# Data Can Be Added and Viewed
   The application supports adding and viewing data through various functionalities:

1. Adding Data: Users can add items to the cart, register, and submit contact forms.
2. Viewing Data: Users can view menu items, cart contents, and order summaries.
# History of Commits from Both Team Members to a Git Repository
   The project has a comprehensive commit history with contributions from both team members:

1. Commit History: The repository shows a detailed history of commits, demonstrating collaborative development.
2. Commit Messages: Each commit is clearly commented, providing context and details about the changes made.
# Uses OOP, and Utilizes Multiple Classes, Including at Least One Inheritance Relationship
   The project is developed using Object-Oriented Programming (OOP) principles:

1. Multiple Classes: Various classes are defined, such as Controller, DataLayer, Validate, Pricing, and LookupItems.
2. Inheritance: Inheritance is used where appropriate, demonstrating the use of polymorphism and code reusability.
# Contains Full Docblocks for All PHP Files and Follows PEAR Standards
   All PHP files contain comprehensive Docblocks:

1. Docblocks: Each class and method is documented with Docblocks, describing its purpose, parameters, and return values.
2. PEAR Standards: The code adheres to PEAR standards for formatting and naming conventions.
# Has Full Validation on the Server Side Through PHP
   The project ensures full server-side validation:

1. Validation: User inputs are validated using functions in the Validate class, ensuring data integrity and security.
2. Error Handling: Appropriate error messages are displayed for invalid inputs, guiding the user to correct mistakes.
# All Code Is Clean, Clear, and Well-Commented. DRY (Don't Repeat Yourself) Is Practiced
   The codebase is maintained with high standards of cleanliness and clarity:

1. Clean Code: The code is well-organized and follows best practices for readability.
1. Comments: In-line comments explain the logic and functionality, aiding in understanding and maintenance.
1. DRY Principle: Reusable functions and classes are utilized to avoid redundancy, adhering to the DRY principle.
# Professional Submission Showing Adequate Effort for a Final Project in a Full-Stack Web Development Course

1. Effort and Professionalism: The project reflects a thorough understanding of full-stack development principles and attention to detail.
2. Functionality and Design: The application is fully functional, with a user-friendly design and seamless user experience.

# Most Recent UML Diagram
![Screenshot 2024-06-12 234705](https://github.com/HansenBlakestudentgreenriveredu/CTRLFreaks/assets/68962947/29ae6546-81d6-4e0e-bfaf-84ac5f1bd6cc)

# Github Contribution Insight
![Screenshot 2024-06-12 234636](https://github.com/HansenBlakestudentgreenriveredu/CTRLFreaks/assets/68962947/3bbe6e06-d78a-45db-9781-b5310d541f57)

# Authors
Team Member 1: https://github.com/vladoleksiyenko

Team Member 2: https://github.com/Tilak-21

Team Member 3: https://github.com/HansenBlakestudentgreenriveredu

# Acknowledgments
Special thanks to our course instructor for your guidance :)
