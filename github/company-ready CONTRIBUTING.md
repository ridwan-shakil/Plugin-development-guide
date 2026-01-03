# Contributing Guidelines

Thank you for contributing to this WordPress plugin.  
This document defines the standards and workflow required to maintain code quality, stability, and consistency across the project.

---

## Table of Contents

- Development Workflow
- Branching Strategy
- Coding Standards
- Commit Message Guidelines
- Testing Requirements
- Pull Request Process
- Code Review Rules
- Security & Quality Rules

---

## Development Workflow

All development follows a **task-based workflow**.

1. Work must be linked to a task (Jira / GitHub Issue / ClickUp).
2. Each task is implemented in its own branch.
3. Code must pass all local tests before opening a Pull Request.
4. CI checks must pass before merging.
5. Direct commits to `main` or `develop` are not allowed.

---

## Branching Strategy

### Protected Branches
- `main` → production-ready code
- `develop` → active development

________________________________________
## Working Branches
### Create a new branch from `develop`:
    git checkout develop
    git pull origin develop
    git checkout -b feature/task-description

### Branch naming conventions:
•	feature/* – new features
•	bugfix/* – bug fixes
•	hotfix/* – critical production fixes
________________________________________

## Coding Standards : All code must follow WordPress standards.
PHP
    •	Follow WordPress PHP Coding Standards
    •	Use OOP and existing architecture
    •	No deprecated WordPress or PHP functions
    •	No PHP notices or warnings with WP_DEBUG enabled
    
Security
    •	Sanitize all input
    •	Validate data before saving
    •	Escape all output
    •	Use nonces and capability checks where required
    
JavaScript & Assets
    •	Use jQuery unless specified otherwise
    •	Enqueue scripts/styles properly
    •	Load assets conditionally
        
________________________________________
## Commit Message Guidelines: 
Commits must be small, logical, and descriptive.
### Format:
    type: short description
    
### Examples:
    feat: add license activation validation
    fix: prevent duplicate order submission
    test: add unit tests for settings save
    chore: refactor admin settings class
    
### Avoid:
•	update
•	fix bug
•	changes
________________________________________
## Testing Requirements : 
### Before opening a Pull Request, contributors must run tests locally:
    composer install
    vendor/bin/phpcs
    vendor/bin/phpunit
    wpcs

### Rules:
•	PHPCS must pass
•	PHPUnit tests must pass
•	CI failures caused by skipped local tests are not acceptable
________________________________________
## Pull Request Process
1.	Push your branch to the repository
2.	Open a Pull Request targeting develop
3.	Provide a clear PR description:
    o	What was changed
    o	Why it was changed
    o	How to test

        
### Pull Request Requirements
•	CI checks must pass
•	Code must meet acceptance criteria
•	At least one approval is required
________________________________________
## Code Review Rules
### Reviewers will check:
•	Logic correctness
•	Security & data handling
•	Performance impact
•	Code readability
•	Test coverage
    
## Contributors must:
•	Respond to feedback professionally
•	Push fixes to the same branch
•	Avoid force-pushing unless instructed
________________________________________

## Merge Rules
•	Only approved PRs may be merged
•	CI must be green
•	Merge method is determined by the project (squash / rebase / merge)
•	Contributors do not merge their own PRs unless permitted
________________________________________
## Security & Quality Rules
### The following are strictly prohibited:
•	Hardcoded credentials
•	Debug code or commented junk
•	Bypassing CI checks
•	Direct commits to protected branches
    Security issues should be reported privately to the project maintainer.
________________________________________

## Final Notes
•	One task = one branch
•	Core logic before UI
•	Tests are part of the feature, not optional
•	CI passing does not replace acceptance criteria
•	Code quality is prioritized over speed
    
Thank you for helping keep this plugin stable, secure, and maintainable.
