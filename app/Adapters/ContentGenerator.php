<?php

namespace App\Adapters;

class ContentGenerator
{
    public array $rows = [];

    public function generate(array $data): string
    {
        $this->rows[] = sprintf('"%s" by %s ✨', $data['title'], $data['creator']['name']);

        $this->rows[] = sprintf('This ZOI has received %d likes and %d downloads so far 🔥', $data['stats']['likes'], $data['stats']['downloads']);

        $this->rows[] = sprintf('Published on %s 📅', $data['publication_date']);

        $this->rows[] = "This beautiful ZOI has been made on inZOI: Character Studio - available for free on Steam 🎮";

        $this->rows[] = "Discover more ZOIs presets on https://canvas.playinzoi.com/explore 🌐";

        $this->rows[] = sprintf("Don't forget to follow @%s on Canvas to support their incredible work! ♥️", $data['creator']['name']);

        $this->rows[] = "#inzoi #thesims #thesims4 #gaming #canvas #krafton #gta5";

        return join("\n\n", $this->rows);
    }
}
