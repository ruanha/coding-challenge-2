function formatTime (milliseconds) {
        let msPerSec = 1000;
        let msPerMin = 60 * 1000;
        let msPerHour = 60 * 60 * 1000;
        
        var hours = Math.floor(milliseconds / msPerHour);
        var minutes = Math.floor((milliseconds % msPerHour) / msPerMin);
        var seconds = Math.floor((milliseconds % msPerMin) / msPerSec);
        return `${hours} hrs, ${minutes} min and ${seconds} sec`;
}

export { formatTime }