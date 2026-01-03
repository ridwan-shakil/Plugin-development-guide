# WordPress Plugin Development Workflow (Task-Based)

This document explains the standard workflow to follow when working on a WordPress plugin after being assigned a task in a professional team environment.

---

## Step 0: Task Assignment

- Tasks come from Jira / GitHub Issues / ClickUp
- Each task includes:
  - Clear description
  - Acceptance criteria
  - Priority
- Read the task carefully before starting
- Ask questions early if anything is unclear

---

## Step 1: Prepare Local Environment

- Clone the repository:
  ```bash
  git clone <repo-url>


### Switch to the development branch:
    git checkout develop
    git pull origin develop

Always start from the latest develop branch.


## Step 2: Create a Feature or Bugfix Branch
### Create a new branch for the task:
    git checkout -b feature/task-short-description
### Branch naming conventions:
    •	feature/* for new features
    •	bugfix/* for bugs
    •	hotfix/* for urgent fixes
________________________________________
## Step 3: Break Task into Subtasks (Before Coding)
    Before writing code:
        •	Identify affected areas:
            o	Core logic
            o	Data storage
            o	Admin / frontend UI
            o	Hooks & filters
            o	Tests
        •	Define small, logical subtasks
        •	Decide implementation order:
            1.	Core logic
            2.	Data handling
            3.	UI
            4.	Tests
            5.	Cleanup
    Never start with UI.
________________________________________
## Step 4: Implement the Task
      •	Follow WordPress & PHP coding standards
      •	Use OOP and existing plugin architecture
      •	Sanitize input and escape output
      •	Make small, meaningful commits
### Good commit messages:
      feat: add license validation logic
      fix: sanitize license input
      test: add unit tests for activation limit
      Avoid vague messages like update or fix.
________________________________________
## Step 5: Self-Review Before Pushing
    Before pushing code:
      •	Remove debug code
      •	Check naming and structure
      •	Ensure no PHP notices with WP_DEBUG=true
      •	Review your own diff
________________________________________
## Step 6: Run Tests Locally
    Always run tests locally before creating a PR:
        composer install
        vendor/bin/phpcs
        vendor/bin/phpunit
Rule:
CI should not fail because of something you could have caught locally.
________________________________________
## Step 7: Push Branch & Create Pull Request
    git push origin feature/task-short-description
### Create a Pull Request:
    •	Base branch: develop
    •	Clear title referencing the task
    •	Description includes:
        o	What was changed
        o	Why it was changed
        o	How to test
________________________________________
## Step 8: Automated CI Checks
    GitHub Actions will run:
        •	PHPCS
        •	PHPUnit
### Rules:
    •	❌ CI failing → PR cannot be merged
    •	Fix issues and push updates to the same branch
________________________________________
## Step 9: Code Review
    •	Reviewer checks:
        o	Logic
        o	Security
        o	Performance
        o	Tests
    •	Respond to feedback professionally
    •	Make requested changes
    •	CI reruns automatically
________________________________________
## Step 10: Merge & Cleanup
    After approval and passing CI:
      •	PR is merged into develop
      •	Delete feature branch
      •	Update local develop branch
  -----------------
    git checkout develop
    git pull origin develop
    git branch -d feature/task-short-description
________________________________________
## Key Principles
    •	One task = one branch
    •	Small commits are preferred
    •	Core logic before UI
    •	Tests are mandatory
    •	CI is non-negotiable
    •	Code quality > speed
________________________________________
## Reminder
    Passing CI means:
      •	Code is technically correct
    Acceptance criteria mean:
      •	Feature behaves correctly
    Both are required for a task to be considered done.
