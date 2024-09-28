<?php

namespace Database\Seeders;

use App\Services\StudyPartnersSuggesterService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

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
        // Shared data for WTC, personality, skills and learning styles
        $wtcData = [
            'stranger_presenting', 'colleague_in_line', 'friend_talking_large',
            'stranger_talking_small', 'friend_in_line', 'colleague_talking_large',
            'stranger_in_line', 'friend_presenting', 'colleague_talking_small',
            'stranger_talking_large', 'friend_talking_small', 'colleague_presenting'
        ];

        $personalityData = [
            'reserved', 'trusting', 'lazy', 'relaxed', 'artistic',
            'outgoing', 'fault_finding', 'thorough', 'nervous', 'imaginative'
        ];

        $skillsData = [
            'interdisciplinary_collaboration', 'online_communication',
            'conflict_resolution', 'organised',
            'problem_solving', 'tech_proficiency',
            'creativity', 'adaptability',
            'leadership', 'teaching_ability'
        ];

        // All rows of data in compact form
        $entries = [
            [
                4,
                'wtcData' => [3, 3, 3, 2, 4, 3, 1, 4, 3, 3, 4, 4],
                'personalityData' => [5, 4, 2, 4, 4, 2, 2, 4, 3, 4],
                'skillsData' => [6, 4, 5, 5, 5, 5, 5, 6, 4, 5],
                'learning_style' => 4,
            ],
            [
                5,
                'wtcData' => [3, 5, 3, 4, 3, 4, 4, 3, 5, 3, 3, 4],
                'personalityData' => [3, 5, 2, 5, 3, 4, 2, 5, 3, 4],
                'skillsData' => [6, 4, 5, 5, 5, 5, 5, 6, 4, 5],
                'learning_style' => 1,
            ],
            [
                6,
                'wtcData' => [1, 5, 5, 2, 5, 4, 4, 5, 5, 1, 5, 2],
                'personalityData' => [3, 3, 4, 4, 3, 3, 1, 3, 4, 4],
                'skillsData' => [6, 4, 3, 3, 5, 5, 5, 6, 4, 3],
                'learning_style' => 1
            ],
            [
                7,
                'wtcData' => [3, 4, 4, 4, 5, 3, 4, 4, 4, 3, 5, 3],
                'personalityData' => [3, 4, 4, 4, 3, 2, 3, 3, 3, 4],
                'skillsData' => [6, 4, 3, 3, 5, 3, 5, 6, 4, 3],
                'learning_style' => 4
            ],
            [
                8,
                'wtcData' => [2, 3, 5, 2, 5, 3, 2, 5, 3, 2, 5, 3],
                'personalityData' => [3, 5, 5, 2, 3, 3, 3, 3, 5, 4],
                'skillsData' => [6, 4, 3, 3, 3, 3, 3, 2, 4, 3],
                'learning_style' => 4
            ],
            [
                9,
                'wtcData' => [3, 3, 3, 3, 3, 3, 3, 4, 4, 1, 4, 4],
                'personalityData' => [4, 4, 4, 2, 4, 2, 3, 4, 4, 5],
                'skillsData' => [2, 4, 5, 5, 5, 3, 5, 6, 4, 3],
                'learning_style' => 3
            ],
            [
                10,
                'wtcData' => [4, 5, 5, 5, 5, 5, 5, 5, 5, 4, 5, 5],
                'personalityData' => [2, 5, 4, 5, 4, 5, 2, 5, 1, 5],
                'skillsData' => [6, 4, 3, 5, 5, 5, 5, 6, 4, 5],
                'learning_style' => 1
            ],
            [
                11,
                'wtcData' => [2, 3, 4, 3, 5, 2, 3, 3, 4, 2, 4, 2],
                'personalityData' => [3, 4, 5, 4, 4, 2, 3, 2, 3, 5],
                'skillsData' => [2, 4, 3, 3, 3, 3, 5, 6, 4, 3],
                'learning_style' => 3
            ],
            [
                12,
                'wtcData' => [2, 5, 5, 4, 5, 5, 3, 5, 5, 3, 5, 5],
                'personalityData' => [4, 4, 1, 3, 3, 3, 2, 5, 3, 5],
                'skillsData' => [6, 4, 5, 5, 5, 3, 5, 6, 4, 5],
                'learning_style' => 4
            ],
            [
                13,
                'wtcData' => [2, 4, 3, 3, 3, 3, 3, 3, 5, 2, 3, 3],
                'personalityData' => [3, 4, 2, 4, 2, 4, 1, 3, 2, 3],
                'skillsData' => [6, 4, 5, 5, 3, 3, 3, 6, 4, 5],
                'learning_style' => 4
            ],
            [
                14,
                'wtcData' => [5, 5, 5, 4, 5, 5, 5, 5, 5, 4, 5, 5],
                'personalityData' => [4, 5, 4, 3, 4, 3, 4, 5, 5, 5],
                'skillsData' => [6, 4, 3, 5, 5, 3, 5, 6, 4, 5],
                'learning_style' => 4
            ],
            [
                15,
                'wtcData' => [2, 3, 4, 2, 5, 2, 3, 5, 3, 2, 5, 2],
                'personalityData' => [4, 4, 5, 3, 5, 2, 2, 3, 4, 5],
                'skillsData' => [6, 4, 5, 5, 5, 3, 3, 6, 4, 5],
                'learning_style' => 4
            ],
            [
                16,
                'wtcData' => [2, 4, 5, 2, 5, 4, 2, 5, 4, 2, 5, 2],
                'personalityData' => [3, 4, 4, 2, 3, 3, 2, 2, 4, 5],
                'skillsData' => [6, 4, 3, 3, 3, 5, 5, 6, 4, 5],
                'learning_style' => 4
            ],
            [
                17,
                'wtcData' => [2, 3, 4, 2, 4, 4, 2, 4, 4, 2, 4, 4],
                'personalityData' => [4, 4, 4, 4, 4, 4, 4, 4, 4, 4],
                'skillsData' => [6, 4, 3, 5, 5, 3, 3, 2, 4, 3],
                'learning_style' => 2
            ],
            [
                18,
                'wtcData' => [1, 3, 5, 3, 4, 3, 2, 3, 4, 2, 5, 2],
                'personalityData' => [3, 4, 4, 3, 5, 3, 4, 3, 5, 4],
                'skillsData' => [2, 4, 3, 5, 5, 5, 3, 6, 4, 5],
                'learning_style' => 3
            ],
        ];

        foreach ($entries as $entry) {
            $data = [
                'profile_id' => $entry[0],
                ...array_combine($wtcData, $entry['wtcData']),
                ...array_combine($personalityData, $entry['personalityData']),
                ...array_combine($skillsData, $entry['skillsData']),
                'learning_style' => $entry['learning_style'],
            ];

            $request = new Request($data);
            $this->studyPartnersSuggesterService->handleSuggesterFormData($request);
        }
    }
}
