# Mobire Code Project Setupper

**A command-line tool for automating Laravel project creation and Docker-based development environment setup.**

## Overview

Mobire Code Project Setupper is a PHP command-line application built with Laravel Zero. It automates the repetitive steps involved in starting a new Laravel web application project, helping developers use a consistent project structure and development environment.

The tool was developed by **Andero Elias** during an internship at **Mobire Group OÜ**, in response to a practical need identified during the internship. It also formed the practical part of his 2026 graduation project at Tallinn Industrial Education Centre, Estonia.

## The Problem

Creating a new Laravel project manually can involve several separate tasks: creating directories, installing Laravel, copying and editing Docker configuration files, starting containers, and installing development tools. Repeating these steps for each project takes time and can lead to inconsistent configurations or setup errors.

The aim of this project was to combine these steps into one repeatable workflow.

## Features

Running the project creation command initiates a workflow that:

- Creates a directory for the new project, using the supplied project name.
- Checks whether a directory with that name already exists before creating it.
- Copies prepared configuration templates into the new project.
- Prepares a Docker-based development environment.
- Creates and starts the required Docker containers.
- Installs a new Laravel application.
- Adds PHPStan and PHP CS Fixer to support code quality and consistent formatting.

The generated environment includes application and database services. The graduation project demonstrates a Laravel application running locally after setup.

## Technologies

| Technology | Role |
| --- | --- |
| PHP | Application logic |
| Laravel Zero | Command-line application framework |
| Laravel | Framework installed for the generated web application |
| Docker / Docker Compose | Containerised development environment |
| Composer | PHP dependency management |
| PHPStan | Static analysis |
| PHP CS Fixer | Code style and formatting |
| Git | Version control |

Visual Studio Code and Bitbucket were also used during development.

## Example Command

The graduation project documents the following command, run from the tool's working environment:

```bash
php blueprint app:create PROJECT_NAME
```

Replace `PROJECT_NAME` with the name of the Laravel project to create.

The tool then runs the setup steps in sequence, including project directory creation, configuration setup, Docker container startup, Laravel installation and development-tool installation.

This command is shown to illustrate the tool’s workflow. This repository is presented as a development portfolio project rather than a packaged application with a step-by-step installation guide.

## How It Works


1. Run: php blueprint app:create PROJECT_NAME

2. Check and create project directory
                               
3. Copy configuration templates
                             
4. Prepare Docker environment
                
5. Create and start containers

6. Install Laravel application

7. Install development tools,


The project uses prepared template files to keep the generated configuration consistent between projects.

## Testing

During development, the tool was tested by creating projects with different names and checking that:

- Project directories and configuration files were generated in the expected locations.
- Docker containers could be recreated and started.
- The generated Laravel application opened in a browser at `localhost:8000`.
- PHPStan and PHP CS Fixer were installed and available.

The graduation report describes successful practical testing of these steps. This section does not claim that a separate automated test suite was run.

In the graduation report, the estimated setup time was reduced from **30–60 minutes of manual work to under 2 minutes** using the automated process. This is a project-reported comparison, not a benchmark across different computers or environments.

## Known Limitations and Future Improvements

Xdebug integration was planned but **was not fully implemented** within the graduation project.

Potential future improvements identified in the report include:

- Completing Xdebug setup.
- Allowing users to choose different configuration options or development tools.
- Applying a consistent Docker environment and code-quality tooling to existing projects.
- Integrating with GitHub or Bitbucket repositories.
- Adding a graphical interface and more detailed error handling.

These are future possibilities, **not current features**.

## Project Background

- **Developer:** Andero Elias
- **Internship company:** Mobire Group OÜ
- **Graduation project:** *Veebirakendusprojekti automaatse seadistustööriista loomine arendajale* (*Creating an Automated Web Application Project Setup Tool for Developers*)
- **School:** Tallinn Industrial Education Centre, Estonia
- **Year:** 2026

The project was designed and implemented as a practical solution to a recurring development setup task encountered during the internship.

## Framework Attribution

Built with [Laravel Zero](https://laravel-zero.com/), created by Nuno Maduro and Owen Voke, and other open-source dependencies. Their respective licence and attribution terms apply.

This repository is shared to demonstrate a development project. No separate permission to reuse the project-specific code is granted by this README.

