using GreenAwarenessHub.Areas.Identity.Data;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
namespace GreenAwarenessHub.Models
{
    public class UserQuizAttempt
    {
        [Key]
        public int AttemptID { get; set; }

        [ForeignKey("GreenAwarenessHubUser")]
        public string Id { get; set; }
        public GreenAwarenessHubUser User { get; set; }

        [ForeignKey("Quiz")]
        public int QuizID { get; set; }
        public Quiz Quiz { get; set; }

        public int Score { get; set; }
    }
}
