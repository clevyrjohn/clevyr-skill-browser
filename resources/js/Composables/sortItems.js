export function sortByLevelDesc(a,b) {
    if(a.level > b.level) return -1;
    if(a.level < b.level) return 1;
    return 0;
}

export function sortByLevelAsc(a,b) {
    if(a.level > b.level) return 1;
    if(a.level < b.level) return -1;
    return 0;
}

export function sortByNameDesc(a,b) {
    if(a.name > b.name) return -1;
    if(a.name < b.name) return 1;
    return 0;
}

export function sortByNameAsc(a,b) {
    if(a.name > b.name) return 1;
    if(a.name < b.name) return -1;
    return 0;
}

export function sortByCompanyTotalDesc(a,b) {
    if(a.companyTotal > b.companyTotal) return -1;
    if(a.companyTotal < b.companyTotal) return 1;
    return 0;
}

export function sortByCompanyTotalAsc(a,b) {
    if(a.companyTotal > b.companyTotal) return 1;
    if(a.companyTotal < b.companyTotal) return -1;
    return 0;
}
