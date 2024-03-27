using GreenAwarenessHub.Areas.Identity.Data;
using System.ComponentModel.DataAnnotations;

using System.ComponentModel.DataAnnotations.Schema;

namespace GreenAwarenessHub.Models
{
    public class Feedback
    {
        [Key]
        public int FeedbackID { get; set; }

        [ForeignKey("GreenAwarenessHubUser")]
        public string Id { get; set; }
        public GreenAwarenessHubUser User { get; set; }

        [ForeignKey("Article")]
        public int ArticleID { get; set; }
        public Article Article { get; set; }

        [Required]
        public string ? FeedbackText { get; set; }
    }
}
