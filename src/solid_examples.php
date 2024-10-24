<?php
declare(strict_types=1);

// 1. Single Responsibility Principle (SRP)
// The Product class has sole responsibility for handling a product's information
class Product {
    public function __construct(
        private string $name,
        private float $price
    ) {}

    public function getName(): string {
        return $this->name;
    }

    public function getPrice(): float {
        return $this->price;
    }
}

// The ProductPrinter class is only responsible for displaying product data
class ProductPrinter {
    public function printProduct(Product $product): string {
        return "Producto: {$product->getName()}, Precio: {$product->getPrice()}€";
    }
}

// 2. Open/Closed Principle (OCP)
// Interface that defines the base behavior
interface Discount {
    public function apply(float $price): float;
}

// We can add new discount types without modifying the existing code
class RegularDiscount implements Discount {
    public function apply(float $price): float {
        return $price * 0.9; // 10% descuento
    }
}

class PremiumDiscount implements Discount {
    public function apply(float $price): float {
        return $price * 0.8; // 20% descuento
    }
}

// 3. Liskov Substitution Principle (LSP)
// Base class that defines common behavior
abstract class Vehicle {
    abstract public function getMaxSpeed(): int;
    
    public function startEngine(): string {
        return "Motor arrancado";
    }
}

// Derived classes can easily replace the base class
class Car extends Vehicle {
    public function getMaxSpeed(): int {
        return 200;
    }
}

class Bicycle extends Vehicle {
    public function getMaxSpeed(): int {
        return 30;
    }
    
    // We overwrite the motor method since a bicycle has no
    public function startEngine(): string {
        return "La bicicleta no tiene motor";
    }
}

// 4. Interface Segregation Principle (ISP)
// Small, specific interfaces instead of a large one
interface Walkable {
    public function walk(): string;
}

interface Swimmable {
    public function swim(): string;
}

interface Flyable {
    public function fly(): string;
}

// Each class implements only the interfaces it needs
class Duck implements Walkable, Swimmable, Flyable {
    public function walk(): string {
        return "El pato camina";
    }
    
    public function swim(): string {
        return "El pato nada";
    }
    
    public function fly(): string {
        return "El pato vuela";
    }
}

class Fish implements Swimmable {
    public function swim(): string {
        return "El pez nada";
    }
}

// 5. Dependency Inversion Principle (DIP)
// Data Persistence Interface
interface Storage {
    public function save(string $data): void;
}

// Concrete implementations
class FileStorage implements Storage {
    public function save(string $data): void {
        // Simula guardar en archivo
        echo "Guardando en archivo: $data\n";
    }
}

class DatabaseStorage implements Storage {
    public function save(string $data): void {
        // Simula guardar en base de datos
        echo "Guardando en base de datos: $data\n";
    }
}

// High-level class that depends on an abstraction
class Logger {
    public function __construct(
        private Storage $storage
    ) {}

    public function log(string $message): void {
        $this->storage->save(date('Y-m-d H:i:s') . ": " . $message);
    }
}

// Example of use
function runExample(): void {
    echo "Ejemplos de SOLID:\n\n";

    // SRP
    $product = new Product("Laptop", 999.99);
    $printer = new ProductPrinter();
    echo "1. SRP - " . $printer->printProduct($product) . "\n";

    // OCP
    $regularDiscount = new RegularDiscount();
    $premiumDiscount = new PremiumDiscount();
    echo "2. OCP - Precio con descuento regular: " . $regularDiscount->apply($product->getPrice()) . "€\n";
    echo "2. OCP - Precio con descuento premium: " . $premiumDiscount->apply($product->getPrice()) . "€\n";

    // LSP
    $car = new Car();
    $bicycle = new Bicycle();
    echo "3. LSP - Coche: " . $car->startEngine() . ", Velocidad máxima: " . $car->getMaxSpeed() . "km/h\n";
    echo "3. LSP - Bicicleta: " . $bicycle->startEngine() . ", Velocidad máxima: " . $bicycle->getMaxSpeed() . "km/h\n";

    // ISP
    $duck = new Duck();
    $fish = new Fish();
    echo "4. ISP - " . $duck->fly() . ", " . $duck->swim() . "\n";
    echo "4. ISP - " . $fish->swim() . "\n";

    // DIP
    $fileLogger = new Logger(new FileStorage());
    $dbLogger = new Logger(new DatabaseStorage());
    echo "5. DIP - ";
    $fileLogger->log("Prueba de log en archivo");
    echo "5. DIP - ";
    $dbLogger->log("Prueba de log en base de datos");
}

// Run the examples
runExample();