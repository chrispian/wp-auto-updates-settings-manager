# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2018-10-19
- Initial Release

## [1.0.1] - 2019-01-19
- Fixed various bugs that were preventing updates from running
- Refactored to address bug preventing saving options erased the options for all other tabs

## [2.0.0] - 2019-02-01
- Refactored to OOP with Composer PSR-4 style autoloding

## [2.0.1] - 2019-02-01
- Removed commented out code that's no longer necessary
- Somehow removed a section of code when launching this, added that back.

## [2.0.2] - 2019-02-01
- Put a hackey fix in for calling the Core class until I figure out the right way
- Fixed the logic in the update check where it wasn't setting a status if there were no excluded items (returns true by default now)

## [2.0.3] - 2019-02-015
- Fixed the hacky way I was calling the Core class
- Removed unnecssary 'USE' at the top since it's autoloading
