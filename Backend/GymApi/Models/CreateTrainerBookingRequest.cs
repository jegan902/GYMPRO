namespace GymApi.Models
{
    public class CreateTrainerBookingRequest
    {
        public int MemberId { get; set; }

        public int TrainerId { get; set; }

        public DateTime StartDate { get; set; }

        public int TotalSessions { get; set; }
    }
}
