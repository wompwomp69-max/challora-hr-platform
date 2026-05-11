import json
import re
from typing import List, Dict, Any

try:
    from . import config
except ImportError:
    import config


class ChallyAssistantV2:
    def __init__(self) -> None:
        self.client = config.get_client()
        self.model_name = config.MODEL_NAME

    def _chat(self, prompt: str) -> str:
        response = self.client.chat.completions.create(
            model=self.model_name,
            messages=[{"role": "user", "content": prompt}],
            temperature=0.3,
        )
        return response.choices[0].message.content or ""

    def _extract_json(self, text: str, default: Any = None) -> Any:
        normalized = text.strip()
        try:
            return json.loads(normalized)
        except json.JSONDecodeError:
            pass
        for pattern in [r'\{.*\}', r'\[.*\]']:
            match = re.search(pattern, normalized, re.DOTALL)
            if match:
                try:
                    return json.loads(match.group(0))
                except json.JSONDecodeError:
                    pass
        return default

    def rate_candidate(self, job_description: str, candidate_name: str, candidate_profile: Dict[str, Any]) -> Dict[str, Any]:
        job_title       = candidate_profile.get("job_title", "")
        job_skills      = candidate_profile.get("job_required_skills", [])
        experience_level = candidate_profile.get("job_experience_level", "")
        min_education   = candidate_profile.get("job_min_education", "")

        prompt = f"""You are Chally AI, a senior HR Intelligence Specialist with 15 years of recruitment experience.
Evaluate how well this candidate fits the job using the structured rubric below.

════════════════════════════════════════
JOB REQUIREMENTS
════════════════════════════════════════
Title            : {job_title}
Experience Level : {experience_level}
Min. Education   : {min_education}
Required Skills  : {", ".join(job_skills) if job_skills else "Not specified"}
Job Description  :
{job_description}

════════════════════════════════════════
CANDIDATE: {candidate_name}
════════════════════════════════════════
{json.dumps(candidate_profile, ensure_ascii=False, indent=2)}

════════════════════════════════════════
SCORING RUBRIC (total = 100 pts)
════════════════════════════════════════
1. Skills Match          (0–30 pts)
   - How many required skills does the candidate demonstrate?
   - Partial credit for adjacent/transferable skills.

2. Work Experience       (0–25 pts)
   - Relevance of past roles to this position.
   - Seniority and progression match the experience level required.
   - Years of experience vs. what the role demands.

3. Education             (0–15 pts)
   - Does the candidate meet or exceed the minimum education requirement?
   - Relevance of major/field of study to the role.

4. Achievements & Org    (0–15 pts)
   - Notable achievements, awards, certifications relevant to the role.
   - Leadership or organizational experience that adds value.

5. Profile Quality       (0–15 pts)
   - Clarity and depth of professional summary.
   - Overall completeness and professionalism of the profile.

════════════════════════════════════════
INSTRUCTIONS
════════════════════════════════════════
- Score each dimension honestly. Do NOT inflate scores.
- A score of 70+ means a strong candidate worth interviewing.
- A score below 40 means a poor fit.
- core_strength must be a single short phrase (e.g. "Strong backend engineering background").
- confidence is your certainty in this score (0.0–1.0) based on how complete the profile is.

Return ONLY a JSON object (no markdown, no explanation):
{{
  "score_total": 0,
  "score_breakdown": {{
    "skills_match": 0,
    "work_experience": 0,
    "education": 0,
    "achievements": 0,
    "profile_quality": 0
  }},
  "reasoning": "2-3 sentence overall assessment",
  "technical_reasoning": ["specific point 1", "specific point 2", "specific point 3"],
  "core_strength": "single phrase",
  "confidence": 0.0
}}"""
        text = self._chat(prompt)
        payload = self._extract_json(text, default={}) or {}
        if not isinstance(payload, dict):
            payload = {}
        payload.setdefault("score_total", 0)
        payload.setdefault("score_breakdown", {})
        payload.setdefault("reasoning", "No reasoning provided")
        payload.setdefault("technical_reasoning", [])
        payload.setdefault("core_strength", "N/A")
        payload.setdefault("confidence", 0.0)
        return payload

    def summarize_candidate(self, job_description: str, candidate_name: str, candidate_profile: Dict[str, Any]) -> Dict[str, Any]:
        job_title = candidate_profile.get("job_title", "")

        prompt = f"""You are Chally AI, a senior HR Intelligence Specialist.
Write a concise talent assessment for this candidate applying for the role below.

════════════════════════════════════════
JOB: {job_title}
════════════════════════════════════════
{job_description}

════════════════════════════════════════
CANDIDATE: {candidate_name}
════════════════════════════════════════
{json.dumps(candidate_profile, ensure_ascii=False, indent=2)}

════════════════════════════════════════
INSTRUCTIONS
════════════════════════════════════════
- pros: 3–5 specific strengths relevant to this role (not generic)
- cons: 2–4 honest gaps or risks for this role
- short_summary: 2–3 sentence paragraph summarizing overall fit
- recommendation: one of exactly these values: "Highly Recommended", "Recommended", "Consider", "Not Recommended"

Return ONLY a JSON object (no markdown, no explanation):
{{
  "pros": ["strength 1", "strength 2", "strength 3"],
  "cons": ["gap 1", "gap 2"],
  "short_summary": "2-3 sentence paragraph",
  "recommendation": "Recommended"
}}"""
        text = self._chat(prompt)
        payload = self._extract_json(text, default={}) or {}
        if not isinstance(payload, dict):
            payload = {}
        payload.setdefault("pros", [])
        payload.setdefault("cons", [])
        payload.setdefault("short_summary", "No summary available.")
        payload.setdefault("recommendation", "Consider")
        return payload

    def recommend_jobs_for_user(self, user_profile: Dict[str, Any], jobs: List[Dict[str, Any]]) -> List[Dict[str, Any]]:
        prompt = f"""You are Chally AI recommendation engine.
Match candidate profile against jobs and return match scores.

[USER PROFILE]
{json.dumps(user_profile, ensure_ascii=False)}

[JOB LIST]
{json.dumps(jobs, ensure_ascii=False)}

Return ONLY a JSON array (no markdown, no explanation):
[
  {{"job_id": 1, "match_score": 0, "reasoning": "Why this job fits"}}
]"""
        text = self._chat(prompt)
        payload = self._extract_json(text, default=[]) or []
        if not isinstance(payload, list):
            payload = []
        normalized = [
            {
                "job_id": item.get("job_id"),
                "match_score": int(item.get("match_score", 0)),
                "reasoning": item.get("reasoning", "No reasoning provided"),
            }
            for item in payload if isinstance(item, dict)
        ]
        return sorted(normalized, key=lambda x: x["match_score"], reverse=True)
