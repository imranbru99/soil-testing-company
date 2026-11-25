<?php

namespace App\Services;

use App\Models\ChatLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiService
{
    /** @var array<int, array{q: string, a: string}> */
    protected array $faq = array (
  0 => 
  array (
    'q' => 'agricultural nutrient npk ph organic matter fertilizer',
    'a' => 'TerraCore agricultural panels cover N-P-K, micronutrients, pH, and organic matter with grower-ready recommendations. Call (515) 555-0167 for spring grid sampling.',
  ),
  1 => 
  array (
    'q' => 'compaction proctor nuclear density fill pad construction',
    'a' => 'We run field nuclear density with lab Proctors so embankments and building pads document percent compaction for inspectors.',
  ),
  2 => 
  array (
    'q' => 'contamination tph metals pesticide spill screening',
    'a' => 'Contamination screens include TPH, RCRA metals, and common pesticide suites with chain-of-custody from field to bench.',
  ),
  3 => 
  array (
    'q' => 'geotech atterberg grain size moisture classification',
    'a' => 'Index testing covers Atterberg limits, grain size, moisture, and USCS classification for Midwest geotech partners.',
  ),
  4 => 
  array (
    'q' => 'landfill cover compliance intermediate daily soil',
    'a' => 'We verify landfill cover soils against permit criteria for moisture and gradation so operators stay audit-ready.',
  ),
  5 => 
  array (
    'q' => 'garden residential lawn raised bed lead',
    'a' => 'Home garden kits include fertility advice and optional lead screening explained in plain language.',
  ),
  6 => 
  array (
    'q' => 'schedule quote des moines ames ankeny cedar rapids cost price',
    'a' => 'Call (515) 555-0167, use the contact form, or WhatsApp. We serve Des Moines, Ames, Ankeny, Cedar Rapids, and Central Iowa.',
  ),
  7 => 
  array (
    'q' => 'turnaround rush lab results how long report',
    'a' => 'Standard ag panels are typically a few business days; construction QA can be same-day or next-day with rush. Ask at intake.',
  ),
);

    public function chat(string $message, ?string $sessionId = null): array
    {
        $reply = null;
        $source = 'demo';

        if ($key = config('services.openai.key')) {
            try {
                $reply = $this->callOpenAi($message, $key);
                $source = 'openai';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply && ($gemini = config('services.gemini.key'))) {
            try {
                $reply = $this->callGemini($message, $gemini);
                $source = 'gemini';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply) {
            $reply = $this->demoReply($message);
            $source = 'demo';
        }

        ChatLog::query()->create([
            'session_id' => $sessionId,
            'message' => $message,
            'reply' => $reply,
            'source' => $source,
        ]);

        return ['reply' => $reply, 'source' => $source];
    }

    public function generate(string $type, string $prompt): string
    {
        $message = match ($type) {
            'blog' => "Write a concise SEO blog post outline and intro for a soil testing business about: {$prompt}",
            'description' => "Write a compelling service description for soil testing: {$prompt}",
            'automation' => "Suggest 5 practical AI automations for a soil testing SME ERP related to: {$prompt}",
            'troubleshoot' => "Troubleshoot this soil testing operations issue with clear steps: {$prompt}",
            default => $prompt,
        };

        $result = $this->chat($message);

        return $result['reply'];
    }

    protected function demoReply(string $message): string
    {
        $hay = Str::lower($message);
        $best = null;
        $bestScore = 0;

        foreach ($this->faq as $item) {
            $score = 0;
            foreach (explode(' ', $item['q']) as $word) {
                if ($word !== '' && str_contains($hay, $word)) {
                    $score++;
                }
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $item['a'];
            }
        }

        if ($best && $bestScore > 0) {
            return $best;
        }

        return 'Thanks for reaching TerraCore Soil Labs. We provide agricultural nutrient analysis, compaction testing, contamination screens, geotech index tests, landfill cover QA, and garden soil analysis across Central Iowa. Ask about panels, turnaround, or scheduling—or call (515) 555-0167.';
    }

    protected function callOpenAi(string $message, string $key): string
    {
        $response = Http::withToken($key)
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => config('services.openai.model', 'gpt-4o-mini'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are the TerraCore Soil Labs assistant for a Des Moines, IA soil testing laboratory. Be concise about agricultural nutrients, compaction, contamination screens, geotech index tests, landfill cover, garden soil, and scheduling. Never invent lab certifications you cannot verify.',
                    ],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.4,
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'choices.0.message.content', 'Unable to generate a response.');
    }

    protected function callGemini(string $message, string $key): string
    {
        $model = config('services.gemini.model', 'gemini-1.5-flash');
        $response = Http::timeout(30)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$key}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "TerraCore Soil Labs assistant (Des Moines / Central Iowa soil testing). Answer briefly:
{$message}"],
                        ],
                    ],
                ],
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'candidates.0.content.parts.0.text', 'Unable to generate a response.');
    }
}