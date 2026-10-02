<?php

declare(strict_types=1);

// Demo data for the preview only.
return static fn (): array => ['invoices' => collect([
    ['number' => 'INV-2041', 'client' => 'Northwind Ltd', 'amount' => '$1,250.00', 'overdue' => false],
    ['number' => 'INV-2042', 'client' => 'Blue Harbor', 'amount' => '$480.00', 'overdue' => true],
    ['number' => 'INV-2043', 'client' => 'Kestrel & Co', 'amount' => '$3,900.00', 'overdue' => false],
    ['number' => 'INV-2044', 'client' => 'Maple Studio', 'amount' => '$215.50', 'overdue' => true],
])];
