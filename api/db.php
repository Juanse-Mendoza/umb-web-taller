<?php

class SupabaseDB {
    private $apiUrl = "https://wbpuplonbaeizimormcq.supabase.co";
    private $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6IndicHVwbG9uYmFlaXppbW9ybWNxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjMzOTk5MjcsImV4cCI6MjA3ODk3NTkyN30.0jiYmXAD8z6cOC8SKEyZ3UCRbPV_W2Oi23OMa-ycKvc";
    
    public function request($table, $method = "GET", $data = null) {
        $url = $this->apiUrl . $table;

        $headers = [
            "apikey: {$this->apiKey}",
            "Authorization: Bearer {$this->apiKey}",
            "Content-Type: application/json"
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
        ];

        if ($method === "POST") {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        if ($method === "PATCH") {
            $options[CURLOPT_CUSTOMREQUEST] = "PATCH";
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        if ($method === "DELETE") {
            $options[CURLOPT_CUSTOMREQUEST] = "DELETE";
        }

        $ch = curl_init();
        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
