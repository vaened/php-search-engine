## PHP Search Engine

The Search Library provides a fundamental and flexible foundation for building search engines in applications. This library is not tied to
any specific ORM implementation; rather, it serves as the core upon which more complex search solutions can be built in other libraries that
integrate with specific ORMs.

```php
class ProductSearchEngine extends SearchEngine  
{  
    use Flagable, Indexed;  
  
    public function __construct(  
        private readonly IndexRepository $index,  
        private readonly FlagFiltrator   $filter  
    ) {  
        $this->apply(Criterias\ProductStatus::active());  
    }  
  
    protected function filterer(): Filterer  
    {  
        return $this->filter;  
    }  
  
    protected function indexer(): indexer  
    {  
        return $this->index;  
    }  
}
```

It offers a robust structure for handling common search functionalities, such as custom filters, text searches, and range management. Its
modular design ensures efficient integration and the ability to extend to cover more sophisticated search needs as project requirements
evolve.

## Installation

PHP Search Engine requires PHP 8.1. To get the latest version, simply require the project using Composer:

```bash
composer require vaened/php-search-engine
```

## Usage
This library provides a foundational framework for creating search engines. It includes the `AbstractSearchEngine` class as a base for custom search implementations and two key traits: `Flagable` for filtering based on flags, and `Indexed` for search operations using indices. These components work together to offer a flexible and extensible solution for managing search criteria.

### Search Engine

The library provides a base class called `AbstractSearchEngine` which offers fundamental functionality typically extended by other libraries for specific implementations. However, it's not mandatory to extend this class—custom implementations of `SearchEngine` can be created from scratch.

**The key feature of `AbstractSearchEngine` is the `apply` method:**

```php
protected function apply(Scope|Expression|Filter ...$criterias): void
{
    $this->criterias = array_merge($this->criterias, $criterias);
}
```
> This method progressively builds search criteria based on applied filters, ultimately constructing the Criteria object.
> 

#### Criteria

The criteria method is responsible for creating a Criteria instance that encapsulates all the search criteria:
```php
protected function criteria(int $page = 1, ?int $perPage = null): Criteria
{
    $perPage ??= $this->perPage;
    $offset  = ($page - 1) * $perPage;

    return new Criteria($this->criterias, $this->order, $perPage, $offset);
}
```
> This method calculates the pagination offset and initializes the Criteria object with the accumulated search criteria, order, and pagination details.
> 
### Flagable Trait
The Flagable trait adds the `filter` method to the SearchEngine, allowing you to apply filters based on specific flags. This method takes a FlagBag containing a set of flags and applies the corresponding filters. Each flag becomes a search criterion that is added to the engine.
```php
public function filter(FlagBag $flags): self
{
    $this->filterer()
         ->only($flags)
         ->each(
             fn(Scope|Expression|Filter $criteria) => $this->apply($criteria)
         );

    return $this;
}
```

### Indexed Trait
The Indexed trait provides the `search` method, which allows you to perform searches based on a specific index. It uses an index defined by the BackedEnum and a queryString to search for the associated criterion in the index repository. If a valid criterion is found, it is applied to the search engine.
```php
public function search(BackedEnum $index, ?string $queryString): static
{
    if (
        null !== $queryString &&
        null !== (
        $criteria = $this->indexer()->search($index, $queryString)
        )
    ) {
        $this->apply($criteria);
    }

    return $this;
}
```

## Concepts

### Filters

Filters represent conditions applied during the search process. These filters are crucial for defining and refining search criteria according to specific requirements. Filters can be simple, such as a direct value check, or more complex, combining multiple conditions to restrict results in detail.
> **Example of internal definition**
```php
interface Filter  
{  
    public function field(): FilterField;  
  
    public function operator(): FilterOperator;  
  
    public function value(): FilterValue;  
}
```

### Flags

Flags are represented by classes that define binary filters, meaning they do not require additional parameters to determine whether a condition is met or not. These filters act as boolean indicators that apply predefined conditions without needing extra input values. Flags return a collection of filters based on the flag parameter provided.

> **Example of internal implementation**
```php
public function only(FlagBag $flags): ArrayList
{
    return $this->flags()
                ->only($flags)
                ->map(static fn(callable $criteria) => apply($criteria));
}
```

### Indexes
Indexes are represented by classes that manage specific search indices. Each index is associated with a search criterion that is applied to a given value. The primary function of an Index is to return a single filter based on the provided index and value. This structure allows for optimized and precise searches using predefined indices.

> **Example of internal implementation**
```php
public function search(BackedEnum $index, string $queryString): null|Scope|Expression|Filter
{
    $criteria = $this->indexes()->get($index);

    if (null === $criteria) {
        return null;
    }

    return apply($criteria, [$queryString]);
}
```

## Usage

## Design Principles

In the **Search Library**, each filter is treated as a separate PHP class with its own specific logic. This approach promotes order and cohesion in the design of the search system. By encapsulating filtering logic in separate classes, the code becomes easier to maintain and extend.

For instance, instead of having scattered filtering functions, classes like `PersonId` and `PersonName` are defined, each containing methods such as `equals(value)` or `startsWith(value)`. This not only enhances code clarity but also enables more efficient reuse of filters in different contexts. By keeping filtering logic within dedicated classes, each filter has a single, well-defined responsibility, contributing to a cleaner and more organized design.

## License

This library is licensed under the MIT License. For more information, please see the [`license`](./license) file.