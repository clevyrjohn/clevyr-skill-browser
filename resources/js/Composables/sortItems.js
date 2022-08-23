export function sortByIdDesc(a, b) {
	if (a.id > b.id) return -1;
	if (a.id < b.id) return 1;
	return 0;
}

export function sortByIdAsc(a, b) {
	if (a.id > b.id) return 1;
	if (a.id < b.id) return -1;
	return 0;
}

export function sortByLevelDesc(a, b) {
	if (a.level > b.level) return -1;
	if (a.level < b.level) return 1;
	return 0;
}

export function sortByLevelAsc(a, b) {
	if (a.level > b.level) return 1;
	if (a.level < b.level) return -1;
	return 0;
}

export function sortByNameDesc(a, b) {
	if (a.name > b.name) return -1;
	if (a.name < b.name) return 1;
	return 0;
}

export function sortByNameAsc(a, b) {
	if (a.name > b.name) return 1;
	if (a.name < b.name) return -1;
	return 0;
}

export function sortBySkillNameDesc(a, b) {
	if (a.skill.name > b.skill.name) return -1;
	if (a.skill.name < b.skill.name) return 1;
	return 0;
}

export function sortBySkillNameAsc(a, b) {
	if (a.skill.name > b.skill.name) return 1;
	if (a.skill.name < b.skill.name) return -1;
	return 0;
}

export function sortByHumanNameDesc(a, b) {
	if (a.human.name > b.human.name) return -1;
	if (a.human.name < b.human.name) return 1;
	return 0;
}

export function sortByHumanNameAsc(a, b) {
	if (a.human.name > b.human.name) return 1;
	if (a.human.name < b.human.name) return -1;
	return 0;
}

export function sortByCompanyTotalDesc(a, b) {
	if (a.companyTotal > b.companyTotal) return -1;
	if (a.companyTotal < b.companyTotal) return 1;
	return 0;
}

export function sortByCompanyTotalAsc(a, b) {
	if (a.companyTotal > b.companyTotal) return 1;
	if (a.companyTotal < b.companyTotal) return -1;
	return 0;
}

export function sortByTotalScoreDesc(a, b) {
	if (a.totalScore > b.totalScore) return -1;
	if (a.totalScore < b.totalScore) return 1;
	return 0;
}

export function sortByTotalScoreAsc(a, b) {
	if (a.totalScore > b.totalScore) return 1;
	if (a.totalScore < b.totalScore) return -1;
	return 0;
}

