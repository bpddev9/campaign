<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_titles')->insert([
            [
                'industry_id' => 1,
                "position" => "Compliance Manager",
                "description" => "Ensures the campaign complies with campaign finance laws and regulations; oftentimes this person is responsible for processing contributions and developing the campaign's finance reports.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 1,
                "position" => "Finance Director",
                "description" => "Develops and oversees the implementation of the campaign's finance (i.e., fundraising) plan, including call-time programs, low- and high-dollar events, donor prospecting and research, online fundraising, and direct mail fundraising programs.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 2,
                "position" => "Digital Director",
                "description" => "Ensures the campaign complies with campaign finance laws and regulations; oftentimes this person is responsible for processing contributions and developing the campaign's finance reports.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 3,
                "position" => "Campaign Manager",
                "description" => "Oversees the entire campaign operation and budget, supervising all other staff and consultants to ensure implementation of the campaign plan, including fundraising, messaging, polling, political/outreach, voter contact and get-out-the-vote efforts.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 3,
                "position" => "Candidate's Body Person",
                "description" => "The candidate's personal assistant who travels with and drives the candidate from place to place. This person is responsible for keeping the candidate on schedule, taking notes and facilitating follow-up with individuals the candidate meets, and sometimes making the candidate's travel arrangements.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 3,
                "position" => "Policy Director (or Advisor)",
                "description" => "Crafts the campaign's policy positions, responds to community organizations' policy questionnaires, briefs the candidate on policy issues and helps the candidate prepare for debates, editorial board interviews, and other endorsement-related conversations.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 3,
                "position" => "Research Director",
                "description" => "Performs background research on the candidate and the opposition to inform campaign strategy. They may also vet potential staff, donors or volunteers; research policy issues; and/or track media and other public appearances by the candidate, surrogates, and opponents.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 4,
                "position" => "Communications Director/Press Secretary",
                "description" => "Maintains message discipline within the campaign (often playing an instrumental role in crafting the message) and directs the campaign's media relations efforts. This person builds relationships with the media, oversees media interaction and is often one of the VERY few people on the campaign who is authorized to speak to the press (with the candidate and campaign manager typically being the only others).",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 5,
                "position" => "Field Director",
                "description" => "Creates and oversees the execution of the direct voter outreach plan, which encompasses both the voter persuasion and get-out-the-vote (GOTV) phases. This role generally focuses on doorknocking (aka canvassing), phone banking, and other methods of directly persuading voters.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 5,
                "position" => "Field Organizer",
                "description" => "Recruits and manages volunteers to execute the campaign’s voter contact plan, oftentimes focused on a specific region (e.g., Southern Regional Field Director, Bear County Field Director).",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 5,
                "position" => "Outreach Director/Manager",
                "description" => "Typically, an outreach director is in charge of the campaign's outreach to a particular constituency group (e.g., Women’s Outreach Manager, African-American Outreach Manager), garnering endorsements from key leaders in that community/constituency and spearheading other efforts to engage the constituency in the campaign.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 5,
                "position" => "Political Director",
                "description" => "Works with community leaders and constituency groups (sometimes leading the outreach directly, sometimes overseeing an Outreach Manager) to garner and organize their support for the campaign. The Political Director may oversee the Field Director, or at least works very closely with her/him to coordinate their efforts.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 5,
                "position" => "Scheduler",
                "description" => "Organizes the candidate's schedule, responding to event invitations, seeking out strategic event opportunities, and briefing the candidate prior to events.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 5,
                "position" => "Volunteer Coordinator",
                "description" => "Recruits, organizes, and manages volunteers and volunteer engagement efforts.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 5,
                "position" => "Groundgame team",
                "description" => "Finds sign locations, place and clean up signs, litature drops or in-peson canvassing and in-person polling",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 6,
                "position" => "General Consultant",
                "description" => "Advises the campaign on overall strategy and provides assistance and advice on various aspects of the campaign.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 6,
                "position" => "General Consultant",
                "description" => "Advises the campaign on overall strategy and provides assistance and advice on various aspects of the campaign.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 6,
                "position" => "Compliance and Accounting Consultant",
                "description" => "Ensures the campaign abides by financial and reporting regulations and stays within budget, oftentimes processing contributions and expenditures and completing the required financial reporting.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 6,
                "position" => "Digital Consultant",
                "description" => "Provides advice to the campaign around social media messaging and digital ad buys, oftentimes placing those buys on behalf of the campaign.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 6,
                "position" => "Direct Mail Consultant",
                "description" => "Creates and sends direct (postal) mail to persuade and turn out voters.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 6,
                "position" => "Fundraising Consultant",
                "description" => "Helps the campaign create and execute a fundraising plan spanning several media, including some combination of researching and prospecting individual and institutional (PAC) donors, call time, events, direct mail, e-mail and social media.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 6,
                "position" => "Media Consultant",
                "description" => "Oversees the campaign’s paid media efforts, developing (or helping develop) the campaign’s paid media messages and placing advertising buys for the campaign on television, radio, print and/or digital media.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 6,
                "position" => "Polling Consultant",
                "description" => "Provides the campaign with data about public opinion on relevant issues in the candidate’s district and conducts polls to determine public perception of the candidate, her/his opponent, (prospective) campaign issues and (prospective) campaign messages.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 6,
                "position" => "Research Consultant",
                "description" => "Performs background research on the candidate and the opposition to inform campaign strategy. They may also vet potential staff, donors or volunteers; research policy issues, and/or track media and other public appearances by the candidate, surrogates, and opponents.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'industry_id' => 6,
                "position" => "Targeting Consultant",
                "description" => "Determines the groups of (and specific individual) voters the campaign will target during the persuasion (i.e., convince folks to vote for your candidate) and get-out-the-vote phases of the campaign, using data analytics techniques.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
