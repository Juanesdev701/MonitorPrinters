<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Printer;

class PrinterController extends Controller
{
    // Listar todas las impresoras
    public function index()
    {
        $printers = Printer::all();
        return view('printers.index', compact('printers'));
    }

    // Mostrar el formulario de creación
    public function create()
    {
        return view('printers.create');
    }

    // Guardar una nueva impresora
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ip',
        ]);

        Printer::create($validated);

        return redirect()->route('printers.index')->with('status', 'Printer added successfully');
    }

    // Mostrar el formulario de edición de una impresora
    public function edit($id)
    {
        $printer = Printer::findOrFail($id);
        return view('printers.edit', compact('printer'));
    }

    // Actualizar una impresora existente
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ip',
        ]);

        $printer = Printer::findOrFail($id);
        $printer->update($validated);

        return redirect()->route('printers.index')->with('status', 'Printer updated successfully');
    }

    // Eliminar una impresora
    public function destroy($id)
    {
        $printer = Printer::findOrFail($id);
        $printer->delete();

        return redirect()->route('printers.index')->with('status', 'Printer deleted successfully');
    }

    private function getTonerLevel($ip_address)
    {
        $url = "http://$ip_address/status.cgi";
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
    
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            curl_close($ch);
            return null; // O retorna 0 o un valor predeterminado que indique un error
        }
    
        curl_close($ch);
    
        // Analiza la respuesta HTML como antes
        $dom = \KubAT\PhpSimple\HtmlDomParser::str_get_html($response);
        $toner_level = 0;
    
        foreach ($dom->find('div') as $element) {
            if (strpos($element->plaintext, 'Toner Level') !== false) {
                $toner_level = (int) filter_var($element->next_sibling()->plaintext, FILTER_SANITIZE_NUMBER_INT);
                break;
            }
        }
    
        return $toner_level;
    }
    public function updateTonerLevels()
    {
        $printers = Printer::all();
    
        foreach ($printers as $printer) {
            $toner_level = $this->getTonerLevel($printer->ip_address);
    
            if ($toner_level !== null) { // Verifica que el nivel de tóner es válido
                $printer->toner_level = $toner_level;
                $printer->save();
            } else {
                // Opcional: Loguea o maneja el error de alguna manera
                Log::error("Error retrieving toner level for printer with IP: {$printer->ip_address}");
            }
        }
    
        return redirect()->route('printers.index')->with('status', 'Toner levels updated successfully');
    }
}
    
