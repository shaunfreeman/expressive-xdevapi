# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.0.1 - TBA

### Added

- Nothing

### Changed

- Nothing

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Documentation to reflect namespace change. 

## 2.0.0 - 02/02/202

### Added

- Nothing

### Changed

- Namespace to ShaunFreeman\PhpMysqlXdevapi (Breaking Change)

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing. 

## 1.5.0 - 01/08/202

### Added

- Nothing

### Changed

- Updated Zend namespace to Laminas

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing. 

## 1.4.0 - 10/12/2019

### Added

- Added Standards check to travis ci.
- Added MkDocs ready to start the documentation.
- `XDevApi\Entity\DocumentEntityCollection`.
- `XdevApi\Repository\CollectionRepository::hydrate()`
- Added new properties for `XdevApi\Repository\CollectionRepository`:
    - findAllString
    - findAllSort
    - hydrator
    - entity

### Changed

- Coding standards now [PSR-12](https://www.php-fig.org/psr/psr-12/)
- `XdevApi\Repository\CollectionRepository::findAll()` will now automatically hydrate array with `XDevApi\Entity\DocumentEntity`.
- Changed `zendframework/zend-paginator` and `zendframework/zend-hydrator` to be required dependencies.
- Added check for `id` in `XDevApi\Entity\DocumentEntity`

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing. 

## 1.3.1 - 13\10\2019

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Zend Hal error when given array with key `'_id'`. 

## 1.3.0 - 13\10\2019

### Added

- `XDevApi\Hydrator\DocumentHydrator`
- `XdevApi\ValueObject\DateTime`
- `Xdevapi\ValueObject\Uuid`

### Changed

- Constructor in `XdevApi\Entity\DocumentEntity` changed to public 
  with constructor arguments as required, if Uuid is blank string
  then new Uuid object with be created.
- Added Known issues to `README.md`.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing

## 1.2.1 - 06/10/2019

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- issue #7 removed final form `XDevApi\Repository\CollectionRepository` for using as a base
  repository.
- fixed composer versions.

## 1.2.0 - 06/10/2019

### Added

- Testing against PHP 7.2.
- Change log.
- `XDevApi\Paginator\RepositoryAdapter` for `Zend/Paginator`
- `XDevApi\Repository\CollectionDocumentInterface`
- `XDevApi\Repository\RepositoryInterface`
- `XDevApi\Repository\CollectionRepository`
- `XDevApi\Entity\DocumentEntity`
- `XDevApi\Entity\DocumentEntityInterface`
- `XDevApi\Entity\EntityInterface`

### Changed

- Testing script to install all dependencies in travis.

### Deprecated

- Nothing.

### Removed

- Testing with Docker.

### Fixed

- Testing errors in travis.
- Code coverage now is being updated.

## 1.1.0 - 01/10/2019

### Added

- Nothing.

### Changed

- Using Docker for testing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 1.0.0 - 26/09/2019

Initial release

### Added

- Everything.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.
