### Visualizing the pattern
```
+----------------+
|   Context      |  <-- Your plugin feature that needs exporting
+----------------+
| - strategy     |
| + setStrategy()|
| + exportData() |
+----------------+
        |
        v
+----------------+
| Strategy       |  <-- Interface / contract
+----------------+
| + export($data)|
+----------------+
        ^
        |
+-------------------+   +------------------+   +------------------+
| JsonExport        |   | CsvExport        |   | TxtExport        |
+-------------------+   +------------------+   +------------------+
| + export($data)   |   | + export($data)  |   | + export($data)  |
+-------------------+   +------------------+   +------------------+
```

Context: Your plugin code calling export

Strategy: Interface that all exporters follow

Concrete Strategies: Each format (JSON, CSV, TXT)


### Code Example 
        ```        
        <?php
        // 1️⃣ Strategy Interface
        interface ExportStrategy {
            public function export(array $data);
        }
        
        // 2️⃣ Concrete Strategies
        
        class JsonExport implements ExportStrategy {
            public function export(array $data) {
                return json_encode($data);
            }
        }
        
        class CsvExport implements ExportStrategy {
            public function export(array $data) {
                $csv = '';
                $header = array_keys($data[0]);
                $csv .= implode(',', $header) . "\n";
                foreach ($data as $row) {
                    $csv .= implode(',', $row) . "\n";
                }
                return $csv;
            }
        }
        
        class TxtExport implements ExportStrategy {
            public function export(array $data) {
                $txt = '';
                foreach ($data as $row) {
                    $txt .= implode(' | ', $row) . "\n";
                }
                return $txt;
            }
        }
        
        // 3️⃣ Context Class
        class Exporter {
            private ExportStrategy $strategy;
        
            public function setStrategy(ExportStrategy $strategy) {
                $this->strategy = $strategy;
            }
        
            public function exportData(array $data) {
                return $this->strategy->export($data);
            }
        }
        
        // 4️⃣ Example usage (like in a plugin)
        $data = [
            ['title' => 'Note 1', 'content' => 'Content A'],
            ['title' => 'Note 2', 'content' => 'Content B'],
        ];
        
        $exporter = new Exporter();
        
        // User chooses JSON export
        $exporter->setStrategy(new JsonExport());
        echo $exporter->exportData($data);
        
        // User chooses CSV export
        $exporter->setStrategy(new CsvExport());
        echo $exporter->exportData($data);
        
        // User chooses TXT export
        $exporter->setStrategy(new TxtExport());
        echo $exporter->exportData($data);
        ```
## ✅ Key Points
 1) Context (Exporter) doesn’t know how export is done — it just calls export().
 2) Concrete Strategies handle the details.
 3) Adding a new format (e.g., XML) is as simple as creating XmlExport class — nothing else changes.










### How to know where to use Strategy Pattern?
  There are three clear signals you can look for.
  
## ✅ Signal 1: You have multiple ways to do the same job
    Example from WP plugin world:
    Export data as JSON, CSV, TXT
    Multiple api to do same type job
    Save data using post meta, custom table, or CPT
    Send emails via wp_mail, SMTP, or API

## ✅ Signal 2: You want to add new variations without editing old code
    Example:
    You release a plugin with JSON & CSV export.
    Later you add XML.
    Without Strategy, you edit a huge if/else block.
    With Strategy:
    You create a new class XmlExport
    Everything else stays untouched
    This is called Open/Closed Principle
    (open for extension, closed for modification)
    
## ✅ Signal 3: You want to clean messy code
    If you ever think:
    “This code is getting too bloated.”
    Strategy helps by splitting each behavior into its own class.
