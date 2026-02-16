## Recommended Complete Pipeline Structure
    .github/
     └── workflows/
          ├── quality.yml
          ├── tests.yml
          ├── build.yml
          ├── deploy-wporg.yml
          └── release.yml

## Ideal Professional Flow
    1.	Develop on develop
    2.	PR to main
    3.	CI runs:
          o	PHPCS
          o	PHPStan
          o	PHPUnit
          o	Security checks
    4.	Merge
    5.	Create tag v1.0.0
    6.	GitHub Action:
          o	Builds production ZIP
          o	Deploys to WP.org
          o	Attaches ZIP to GitHub Release
