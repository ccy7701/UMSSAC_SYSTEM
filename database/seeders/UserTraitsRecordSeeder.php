<?php

namespace Database\Seeders;

use App\Services\StudyPartnersSuggesterService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserTraitsRecordSeeder extends Seeder
{
    protected $studyPartnersSuggesterService;

    public function __construct(StudyPartnersSuggesterService $studyPartnersSuggesterService) {
        $this->studyPartnersSuggesterService = $studyPartnersSuggesterService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load entries from the JSON file
        $jsonPath = database_path('data/user_traits_records.json');
        $entries = json_decode(File::get($jsonPath), true);

        // Define mappings for WTC, personality and skills data
        $wtcTraits = [
            'stranger_presenting', 'colleague_in_line', 'friend_talking_large',
            'stranger_talking_small', 'friend_in_line', 'colleague_talking_large',
            'stranger_in_line', 'friend_presenting', 'colleague_talking_small',
            'stranger_talking_large', 'friend_talking_small', 'colleague_presenting'
        ];
        $personalityTraits = [
            'reserved', 'trusting', 'lazy', 'relaxed', 'artistic',
            'outgoing', 'fault_finding', 'thorough', 'nervous', 'imaginative'
        ];
        $skillsTraits = [
            'interdisciplinary_collaboration', 'online_communication',
            'conflict_resolution', 'organised',
            'problem_solving', 'tech_proficiency',
            'creativity', 'adaptability',
            'leadership', 'teaching_ability'
        ];
        
        foreach($entries as $entry) {
            $data = [
                'profile_id' => $entry['profile_id'],
                ...array_combine($wtcTraits, $entry['wtc_data']),
                ...array_combine($personalityTraits, $entry['personality_data']),
                ...array_combine($skillsTraits, $entry['skills_data']),
                'learning_style' => $entry['learning_style'],
            ];

            // Process the data using the StudyPartnersSuggesterService
            $this->studyPartnersSuggesterService->handleSuggesterFormData(new Request($data));
        }
    }
}
